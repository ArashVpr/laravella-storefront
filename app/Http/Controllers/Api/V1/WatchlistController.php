<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\CarResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WatchlistController extends Controller
{
    /**
     * Get user's watchlist.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $cars = $user->favoriteCars()
            ->with(['maker', 'model', 'fuelType', 'carType', 'city.state', 'images', 'owner'])
            ->paginate(20);

        return response()->json([
            'data' => CarResource::collection($cars),
            'meta' => [
                'total' => $cars->total(),
                'per_page' => $cars->perPage(),
                'current_page' => $cars->currentPage(),
            ],
        ]);
    }

    /**
     * Toggle car in watchlist.
     */
    public function toggle(Request $request, int $carId): JsonResponse
    {
        $user = $request->user();

        $exists = $user->favoriteCars()->where('car_id', $carId)->exists();

        if ($exists) {
            $user->favoriteCars()->detach($carId);

            return response()->json([
                'message' => 'Car removed from watchlist',
                'in_watchlist' => false,
            ]);
        }

        $user->favoriteCars()->attach($carId);

        return response()->json([
            'message' => 'Car added to watchlist',
            'in_watchlist' => true,
        ], 201);
    }
}
