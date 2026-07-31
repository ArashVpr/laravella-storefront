<?php

namespace Database\Factories;

use App\Models\CarType;
use App\Models\City;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\CarModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        static $models = null;
        static $users = null;
        static $carTypes = null;
        static $fuelTypes = null;
        static $cities = null;

        if ($models === null) {
            $models = CarModel::all()->keyBy('id');
            $users = User::all();
            $carTypes = CarType::all();
            $fuelTypes = FuelType::all();
            $cities = City::all();
        }

        $model = $models->random();

        return [
            'maker_id' => $model->maker_id,
            'user_id' => $users->random()->id,
            'model_id' => $model->id,
            'car_type_id' => $carTypes->random()->id,
            'fuel_type_id' => $fuelTypes->random()->id,
            'city_id' => $cities->random()->id,
            'year' => fake()->numberBetween(2000, now()->year),
            'price' => fake()->numberBetween(100, 500) * 100,
            'mileage' => fake()->numberBetween(1000, 200000),
            'vin' => strtoupper(fake()->bothify('?###??###??###??#')),
            'address' => fake()->streetAddress,
            'phone' => fake()->phoneNumber,
            'description' => fake()->text(200),
            'created_at' => fake()->dateTimeBetween('-5 year', 'now'),
        ];
    }
}
