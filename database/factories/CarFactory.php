<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Maker;
use App\Models\User;
use App\Models\CarType;
use App\Models\FuelType;
use App\Models\City;
use App\Models\Models;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'maker_id' => Maker::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'model_id' => Models::inRandomOrder()->first()->id,
            'car_type_id' => CarType::inRandomOrder()->first()->id,
            'fuel_type_id' => FuelType::inRandomOrder()->first()->id,
            'city_id' => City::inRandomOrder()->first()->id,
            'year' => fake()->numberBetween(2000, now()->year),
            'price' => fake()->numberBetween(100, 500) * 100,
            "mileage" => fake()->numberBetween(1000, 200000),
            'vin' => strtoupper(fake()->bothify('??###??###??###??###')),
            'address' => fake()->streetAddress,
            'phone' => fake()->phoneNumber,
            'description' => fake()->text(200),
            'created_at' => fake()->dateTimeBetween('-5 year', 'now'),
        ];
    }
}
