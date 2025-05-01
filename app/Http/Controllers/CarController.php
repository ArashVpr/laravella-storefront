<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarRequest;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->session()->get('success');
        $cars = Auth::user()
            ->cars()
            ->with(['primaryImage', 'maker', 'model'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('car.index', ['cars' => $cars]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Gate::allows('create', Car::class)) {
            return redirect()->route('profile.index')
            ->with('warning', 'Please provide your phone number');
        };
        
        return view('car.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarRequest $request)
    {

        // Get request data
        $data = $request->validated();
        // Get features data
        $featuresData = $data['features'] ?? [];
        unset($data['features']);
        // Attach images
        $images = $request->file('images') ?: [];
        unset($data['images']);
        // Set user ID
        $data['user_id'] = Auth::id();
        // Create new car
        $car = Car::create($data);
        // Create features
        $car->features()->create($featuresData);

        // Iterate and create images
        foreach ($images as $index => $image) {
            // Save image on file system
            $path = $image->store('public/images');
            // Create record in the database
            $car->images()->create(['image_path' => $path, 'position' => $index + 1]);
        }
        // Redirect to car.index route
        return redirect()->route('car.index')->with('success', 'Car created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        return view('car.show', ['car' => $car]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        Gate::authorize('update', $car);

        return view('car.edit', ['car' => $car]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCarRequest $request, Car $car)
    {
        // Check if the authenticated user is the owner of the car
        if ($car->user_id !== Auth::id()) {
            abort(403);
        }
        // Validate the request
        $data = $request->validated();
        $features = array_merge([
            'abs' => 0,
            'air_conditioning' => 0,
            'power_windows' => 0,
            'power_door_locks' => 0,
            'cruise_control' => 0,
            'bluetooth_connectivity' => 0,
            'gps_navigation' => 0,
            'heated_seats' => 0,
            'climate_control' => 0,
            'rear_parking_sensors' => 0,
            'leather_seats' => 0,
        ], $data['features'] ?? []);
        $data = $request->validated();
        unset($data['features']);

        $car->update($data);
        $car->features()->update($features);

        return redirect()->route('car.index')->with('success', 'Car updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        Gate::authorize('delete', $car);

        $car->delete();
        return redirect()->route('car.index')->with('success', 'Car deleted successfully');
    }

    public function search(Request $request)
    {
        $maker = $request->integer('maker_id');
        $model = $request->integer('model_id');
        $city = $request->integer('city_id');
        $state = $request->integer('state_id');
        $carType = $request->integer('car_type_id');
        $fuelType = $request->integer('fuel_type_id');
        $yearFrom = $request->integer('year_from');
        $yearTo = $request->integer('year_to');
        $priceFrom = $request->integer('price_from');
        $priceTo = $request->integer('price_to');
        $yearFrom = $request->integer('year_from');
        $yearTo = $request->integer('year_to');
        $mileage = $request->integer('mileage');
        $sort = $request->input('sort', '-created_at');


        $query = Car::where('created_at', '<', now())
            ->with(['primaryImage', 'city', 'carType', 'fuelType', 'maker', 'model', 'favoredUsers']);

        if (str_starts_with($sort, '-')) {
            $sortBy = substr($sort, 1);
            $query->orderBy($sortBy, 'desc');
        } else {
            $query->orderBy($sort);
        }

        if ($maker) {
            $query->where('maker_id', $maker);
        }
        if ($model) {
            $query->where('model_id', $model);
        }
        if ($state) {
            $query->join('cities', 'cities.id', '=', 'cars.city_id')
                ->where('cities.state_id', $state);
        }
        if ($city) {
            $query->where('city_id', $city);
        }
        if ($carType) {
            $query->where('car_type_id', $carType);
        }
        if ($fuelType) {
            $query->where('fuel_type_id', $fuelType);
        }
        if ($yearFrom) {
            $query->where('year', '>=', $yearFrom);
        }
        if ($yearTo) {
            $query->where('year', '<=', $yearTo);
        }
        if ($priceFrom) {
            $query->where('price', '>=', $priceFrom);
        }
        if ($priceTo) {
            $query->where('price', '<=', $priceTo);
        }
        if ($mileage) {
            $query->where('mileage', '<=', $mileage);
        }

        $cars = $query->paginate(15)->withQueryString();

        return view('car.search', ['cars' => $cars]);
    }

    public function showPhone(Car $car)
    {
        return response()->json(['phone' => $car->phone]);
    }
}
