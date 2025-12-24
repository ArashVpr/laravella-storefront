<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\CarCollection;
use App\Http\Resources\CarResource;
use App\Models\Car;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CarController extends Controller
{
    /**
     * Display a listing of cars.
     */
    public function index(Request $request): CarCollection
    {
        $query = Car::with(['maker', 'model', 'fuelType', 'carType', 'city.state', 'images', 'owner']);

        // Apply filters
        if ($request->filled('make_id')) {
            $query->where('maker_id', $request->make_id);
        }

        if ($request->filled('model_id')) {
            $query->where('model_id', $request->model_id);
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('fuel_type_id')) {
            $query->where('fuel_type_id', $request->fuel_type_id);
        }

        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $perPage = min($request->input('per_page', 20), 100); // Max 100 per page
        $cars = $query->paginate($perPage);

        return new CarCollection($cars);
    }

    /**
     * Display the specified car.
     */
    public function show(Car $car): CarResource
    {
        $car->load(['maker', 'model', 'fuelType', 'carType', 'city.state', 'images', 'features', 'owner']);

        return new CarResource($car);
    }

    /**
     * Store a newly created car.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'maker_id' => 'required|exists:makers,id',
            'model_id' => 'required|exists:models,id',
            'year' => 'required|integer|min:1900|max:'.(date('Y') + 1),
            'price' => 'required|numeric|min:0',
            'mileage' => 'required|integer|min:0',
            'fuel_type_id' => 'required|exists:fuel_types,id',
            'car_type_id' => 'nullable|exists:car_types,id',
            'city_id' => 'required|exists:cities,id',
            'state_id' => 'required|exists:states,id',
            'description' => 'nullable|string|max:1000',
        ]);

        $validated['user_id'] = $request->user()->id;
        $car = Car::create($validated);

        $car->load(['maker', 'model', 'fuelType', 'carType', 'city', 'state', 'owner']);

        return response()->json([
            'message' => 'Car created successfully',
            'data' => new CarResource($car),
        ], 201);
    }

    /**
     * Update the specified car.
     */
    public function update(Request $request, Car $car): JsonResponse
    {
        // Authorization
        if ($request->user()->id !== $car->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'maker_id' => 'sometimes|exists:makers,id',
            'model_id' => 'sometimes|exists:models,id',
            'year' => 'sometimes|integer|min:1900|max:'.(date('Y') + 1),
            'price' => 'sometimes|numeric|min:0',
            'mileage' => 'sometimes|integer|min:0',
            'fuel_type_id' => 'sometimes|exists:fuel_types,id',
            'car_type_id' => 'nullable|exists:car_types,id',
            'city_id' => 'sometimes|exists:cities,id',
            'state_id' => 'sometimes|exists:states,id',
            'description' => 'nullable|string|max:1000',
        ]);

        $car->update($validated);
        $car->load(['maker', 'model', 'fuelType', 'carType', 'city', 'state', 'owner']);

        return response()->json([
            'message' => 'Car updated successfully',
            'data' => new CarResource($car),
        ]);
    }

    /**
     * Remove the specified car.
     */
    public function destroy(Request $request, Car $car): JsonResponse
    {
        // Authorization
        if ($request->user()->id !== $car->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $car->delete();

        return response()->json([
            'message' => 'Car deleted successfully',
        ], 204);
    }

    /**
     * Search cars with advanced filters using Meilisearch.
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->input('q', '');
        $filters = [];

        // Build Meilisearch filters
        if ($request->filled('maker')) {
            $filters[] = 'maker = "' . addslashes($request->maker) . '"';
        }

        if ($request->filled('year')) {
            $filters[] = 'year = ' . $request->year;
        }

        if ($request->filled('min_price')) {
            $filters[] = 'price >= ' . $request->min_price;
        }

        if ($request->filled('max_price')) {
            $filters[] = 'price <= ' . $request->max_price;
        }

        if ($request->filled('fuel_type')) {
            $filters[] = 'fuel_type = "' . addslashes($request->fuel_type) . '"';
        }

        if ($request->filled('city')) {
            $filters[] = 'city = "' . addslashes($request->city) . '"';
        }

        if ($request->filled('state')) {
            $filters[] = 'state = "' . addslashes($request->state) . '"';
        }

        if ($request->filled('is_featured')) {
            $filters[] = 'is_featured = ' . ($request->boolean('is_featured') ? 'true' : 'false');
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $sort = [$sortBy . ':' . $sortOrder];

        // Perform search
        $perPage = (int) min($request->input('per_page', 20), 100);
        $page = (int) $request->input('page', 1);

        $searchParams = [
            'filter' => implode(' AND ', $filters),
            'sort' => $sort,
            'limit' => $perPage,
            'offset' => ($page - 1) * $perPage,
        ];

        $results = Car::search($query, function ($meilisearch, $query, $options) use ($searchParams) {
            if (!empty($searchParams['filter'])) {
                $options['filter'] = $searchParams['filter'];
            }
            $options['sort'] = $searchParams['sort'];
            $options['limit'] = $searchParams['limit'];
            $options['offset'] = $searchParams['offset'];

            return $meilisearch->search($query, $options);
        })->get();

        // Get total count for pagination
        $total = Car::search($query, function ($meilisearch, $query, $options) use ($searchParams) {
            if (!empty($searchParams['filter'])) {
                $options['filter'] = $searchParams['filter'];
            }
            $options['limit'] = 0;

            return $meilisearch->search($query, $options);
        })->raw()['estimatedTotalHits'] ?? 0;

        // Load relationships
        $results->load(['maker', 'model', 'fuelType', 'carType', 'city.state', 'images', 'owner']);

        return response()->json([
            'data' => CarResource::collection($results),
            'meta' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'last_page' => ceil($total / $perPage),
            ],
        ]);
    }
}
