<?php

namespace App\GraphQL\Mutations;

use App\Models\Car;

class AddToWatchlist
{
    public function __invoke($root, array $args, $context)
    {
        $user = $context->user();
        $car = Car::findOrFail($args['carId']);
        
        // Check if already in watchlist
        if ($user->watchlist()->where('car_id', $car->id)->exists()) {
            return [
                'message' => 'Car is already in your watchlist',
                'success' => false,
                'car' => $car,
                'inWatchlist' => true,
            ];
        }
        
        // Add to watchlist
        $user->watchlist()->attach($car->id);
        
        return [
            'message' => 'Car added to watchlist',
            'success' => true,
            'car' => $car,
            'inWatchlist' => true,
        ];
    }
}
