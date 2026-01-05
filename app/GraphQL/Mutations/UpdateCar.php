<?php

namespace App\GraphQL\Mutations;

use App\Models\Car;
use Illuminate\Auth\Access\AuthorizationException;

class UpdateCar
{
    public function __invoke($root, array $args, $context)
    {
        $user = $context->user();
        $car = Car::findOrFail($args['id']);
        
        // Check ownership
        if ($car->user_id !== $user->id) {
            throw new AuthorizationException('You can only update your own cars.');
        }
        
        // Update fields if provided
        if (isset($args['make'])) $car->make = $args['make'];
        if (isset($args['model'])) $car->model = $args['model'];
        if (isset($args['year'])) $car->year = $args['year'];
        if (isset($args['price'])) $car->price = $args['price'];
        if (isset($args['mileage'])) $car->mileage = $args['mileage'];
        if (isset($args['description'])) $car->description = $args['description'];
        if (isset($args['transmission'])) $car->transmission = $args['transmission'];
        if (isset($args['fuelType'])) $car->fuel_type = $args['fuelType'];
        if (isset($args['color'])) $car->color = $args['color'];
        if (isset($args['vin'])) $car->vin = $args['vin'];
        if (isset($args['location'])) $car->location = $args['location'];
        if (isset($args['isActive'])) $car->is_active = $args['isActive'];
        
        $car->save();
        
        return $car;
    }
}
