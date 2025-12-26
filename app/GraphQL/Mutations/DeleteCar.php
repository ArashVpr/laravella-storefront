<?php

namespace App\GraphQL\Mutations;

use App\Models\Car;
use Illuminate\Auth\Access\AuthorizationException;

class DeleteCar
{
    public function __invoke($root, array $args, $context)
    {
        $user = $context->user();
        $car = Car::findOrFail($args['id']);
        
        // Check ownership
        if ($car->user_id !== $user->id) {
            throw new AuthorizationException('You can only delete your own cars.');
        }
        
        // Delete the car
        $car->delete();
        
        return [
            'message' => 'Car deleted successfully',
            'success' => true,
        ];
    }
}
