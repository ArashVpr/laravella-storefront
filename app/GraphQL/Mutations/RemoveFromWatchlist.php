<?php

namespace App\GraphQL\Mutations;

use App\Models\Car;

class RemoveFromWatchlist
{
    public function __invoke($root, array $args, $context)
    {
        $user = $context->user();
        $car = Car::findOrFail($args['carId']);
        
        // Remove from watchlist
        $user->watchlist()->detach($car->id);
        
        return [
            'message' => 'Car removed from watchlist',
            'success' => true,
            'car' => $car,
            'inWatchlist' => false,
        ];
    }
}
