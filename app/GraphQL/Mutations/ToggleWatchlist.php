<?php

namespace App\GraphQL\Mutations;

use App\Models\Car;

class ToggleWatchlist
{
    public function __invoke($root, array $args, $context)
    {
        $user = $context->user();
        $car = Car::findOrFail($args['carId']);
        
        // Check if already in watchlist
        $inWatchlist = $user->watchlist()->where('car_id', $car->id)->exists();
        
        if ($inWatchlist) {
            // Remove from watchlist
            $user->watchlist()->detach($car->id);
            $message = 'Car removed from watchlist';
            $success = true;
            $newState = false;
        } else {
            // Add to watchlist
            $user->watchlist()->attach($car->id);
            $message = 'Car added to watchlist';
            $success = true;
            $newState = true;
        }
        
        return [
            'message' => $message,
            'success' => $success,
            'car' => $car,
            'inWatchlist' => $newState,
        ];
    }
}
