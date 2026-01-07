<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarRequest;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Illuminate\View\View
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
    public function create(): \Illuminate\Http\RedirectResponse|\Illuminate\View\View
    {
        if (! Gate::allows('create', Car::class)) {
            return redirect()->route('profile.index')
                ->with('warning', 'Please provide your phone number');
        }

        return view('car.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarRequest $request): \Illuminate\Http\RedirectResponse
    {

        // Get request data
        $data = $request->validated();
        $featuresData = $data['features'] ?? [];
        unset($data['features']);
        $images = $request->file('images') ?: [];
        unset($data['images']);
        $data['user_id'] = Auth::id();

        DB::transaction(function () use ($data, $featuresData, $images) {
            // Create new car
            $car = Car::create($data);
            // Create features
            $car->features()->create($featuresData);

            // Iterate and create images
            foreach ($images as $index => $image) {
                $path = $image->store('images', 'public');
                $car->images()->create(['image_path' => $path, 'position' => $index + 1]);
            }
        });

        // Redirect to car.index route
        return redirect()->route('car.index')->with('success', 'Car created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car): \Illuminate\View\View
    {
        return view('car.show', ['car' => $car]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car): \Illuminate\View\View
    {
        Gate::authorize('update', $car);

        return view('car.edit', ['car' => $car]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCarRequest $request, Car $car): \Illuminate\Http\RedirectResponse
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

        DB::transaction(function () use ($car, $data, $features) {
            $car->update($data);
            $car->features()->update($features);
        });

        return redirect()->route('car.index')->with('success', 'Car updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car): \Illuminate\Http\RedirectResponse
    {
        Gate::authorize('delete', $car);

        $car->delete();

        return redirect()->route('car.index')->with('success', 'Car deleted successfully');
    }

    public function search(Request $request): \Illuminate\View\View
    {
        // Get search parameters
        $q = $request->input('q', ''); // Text search query
        $makerId = $request->integer('maker_id');
        $modelId = $request->integer('model_id');
        $cityId = $request->integer('city_id');
        $stateId = $request->integer('state_id');
        $carTypeId = $request->integer('car_type_id');
        $fuelTypeId = $request->integer('fuel_type_id');
        $yearFrom = $request->integer('year_from');
        $yearTo = $request->integer('year_to');
        $priceFrom = $request->integer('price_from');
        $priceTo = $request->integer('price_to');
        $mileage = $request->integer('mileage');
        $sort = $request->input('sort', '-created_at');

        // Build Eloquent query
        $query = Car::query()->with(['primaryImage', 'city.state', 'carType', 'fuelType', 'maker', 'model', 'favoredUsers']);

        // Apply text search if provided
        if (!empty($q)) {
            $query->where(function ($query) use ($q) {
                $query->where('description', 'like', "%{$q}%")
                    ->orWhereHas('maker', function ($query) use ($q) {
                        $query->where('name', 'like', "%{$q}%");
                    })
                    ->orWhereHas('model', function ($query) use ($q) {
                        $query->where('name', 'like', "%{$q}%");
                    })
                    ->orWhereHas('fuelType', function ($query) use ($q) {
                        $query->where('name', 'like', "%{$q}%");
                    })
                    ->orWhereHas('carType', function ($query) use ($q) {
                        $query->where('name', 'like', "%{$q}%");
                    })
                    ->orWhere('year', 'like', "%{$q}%");
            });
        }

        // Apply filters
        if ($makerId) {
            $query->where('maker_id', $makerId);
        }
        if ($modelId) {
            $query->where('model_id', $modelId);
        }
        if ($cityId) {
            $query->where('city_id', $cityId);
        }
        if ($stateId) {
            $query->whereHas('city', function ($query) use ($stateId) {
                $query->where('state_id', $stateId);
            });
        }
        if ($carTypeId) {
            $query->where('car_type_id', $carTypeId);
        }
        if ($fuelTypeId) {
            $query->where('fuel_type_id', $fuelTypeId);
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

        // Apply sorting
        if (str_starts_with($sort, '-')) {
            $sortField = substr($sort, 1);
            $sortOrder = 'desc';
        } else {
            $sortField = $sort;
            $sortOrder = 'asc';
        }

        // Validate sort field
        $allowedSortFields = ['price', 'year', 'created_at', 'mileage'];
        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $cars = $query->paginate(15)->withQueryString();

        return view('car.search', ['cars' => $cars]);
    }

    public function carImages(Car $car): \Illuminate\View\View
    {
        Gate::authorize('update', $car);

        return view('car.images', ['car' => $car]);
    }

    public function updateImages(Request $request, Car $car): \Illuminate\Http\RedirectResponse
    {
        Gate::authorize('update', $car);

        // Get Validated data of delete images and positions
        $data = $request->validate([
            'delete' => 'nullable|array',
            'delete.*' => 'integer',
            'position' => 'nullable|array',
            'position.*' => 'integer',
        ]);

        $deleteImages = array_keys($data['delete'] ?? []);
        $positions = $data['position'] ?? [];

        // Handle deletions
        if (!empty($deleteImages)) {
            // Select images to delete
            /** @var \Illuminate\Database\Eloquent\Collection<int, \App\Models\CarImage> $imagesToDelete */
            $imagesToDelete = $car->images()->whereIn('id', $deleteImages)->get();

            // Iterate over images to delete and delete them from file system
            foreach ($imagesToDelete as $image) {
                if (Storage::exists($image->image_path)) {
                    Storage::delete($image->image_path);
                }
            }

            // Delete images from the database
            $car->images()->whereIn('id', $deleteImages)->delete();
        }

        // Handle position updates
        if (!empty($positions)) {
            // Iterate over positions and update position for each image, by its ID
            foreach ($positions as $id => $position) {
                $car->images()->where('id', $id)->update(['position' => $position]);
            }
        }

        // If neither deletions nor position updates were provided
        if (empty($deleteImages) && empty($positions)) {
            return redirect()->route('car.images', $car)
                ->with('warning', 'No changes were made');
        }

        // Prepare success message
        $message = '';
        if (!empty($deleteImages) && !empty($positions)) {
            $message = 'Images deleted and positions updated successfully';
        } elseif (!empty($deleteImages)) {
            $message = count($deleteImages) . ' image' . (count($deleteImages) > 1 ? 's' : '') . ' deleted successfully';
        } elseif (!empty($positions)) {
            $message = 'Image positions updated successfully';
        }

        // Redirect back to car.images route
        return redirect()->route('car.images', $car)
            ->with('success', $message);
    }

    public function addImages(Request $request, Car $car): \Illuminate\Http\RedirectResponse
    {
        Gate::authorize('update', $car);

        // Get images from request
        $images = $request->file('images') ?? [];

        if (empty($images)) {
            return redirect()->route('car.images', $car)
                ->with('warning', 'No images were selected');
        }

        // Select max position of car images
        $position = $car->images()->max('position') ?? 0;
        foreach ($images as $image) {
            // Save it on the file system
            $path = $image->store('images', 'public');
            // Save it in the database
            $car->images()->create([
                'image_path' => $path,
                'position' => $position + 1,
            ]);
            $position++;
        }

        return redirect()->route('car.images', $car)
            ->with('success', 'New images were added');
    }

    public function showPhone(Car $car): \Illuminate\Http\JsonResponse
    {
        return response()->json(['phone' => $car->phone]);
    }
}
