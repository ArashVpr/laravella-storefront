<?php

namespace App\GraphQL\Mutations;

use App\Models\Car;

class CreateCar
{
    public function __invoke($root, array $args, $context)
    {
        $user = $context->user();
        
        // Check if user has a phone number
        if (!$user->phone) {
            throw new \Exception('You must add a phone number to your profile before listing a car.');
        }
        
        // Create the car
        $car = new Car();
        $car->user_id = $user->id;
        $car->make = $args['make'];
        $car->model = $args['model'];
        $car->year = $args['year'];
        $car->price = $args['price'];
        $car->mileage = $args['mileage'];
        $car->description = $args['description'] ?? null;
        $car->transmission = $args['transmission'] ?? null;
        $car->fuel_type = $args['fuelType'] ?? null;
        $car->color = $args['color'] ?? null;
        $car->vin = $args['vin'] ?? null;
        $car->location = $args['location'] ?? null;
        $car->is_active = true;
        $car->save();
        
        return $car;
    }
}
