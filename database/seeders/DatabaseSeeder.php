<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarFeature;
use App\Models\CarImages;
use App\Models\Maker;
use App\Models\User;
// use Doctrine\DBAL\Schema\Sequence;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {




        DB::table('makers')->insert([
            ['name' => 'Toyota'],
            ['name' => 'Honda'],
            ['name' => 'Ford'],
            ['name' => 'Chevrolet'],
            ['name' => 'Nissan'],
            ['name' => 'BMW'],
            ['name' => 'Mercedes-Benz'],
            ['name' => 'Volkswagen'],
            ['name' => 'Hyundai'],
            ['name' => 'Kia'],
        ]);

        DB::table('car_types')->insert([
            ['name' => 'Sedan'],
            ['name' => 'Hatchback'],
            ['name' => 'SUV'],
            ['name' => 'Truck'],
            ['name' => 'Van'],
            ['name' => 'Coupe'],
            ['name' => 'Convertible'],
            ['name' => 'Wagon'],
            ['name' => 'Crossover'],
            ['name' => 'Sports Car'],
        ]);

        DB::table('fuel_types')->insert([
            ['name' => 'Gasoline'],
            ['name' => 'Diesel'],
            ['name' => 'Electric'],
            ['name' => 'Hybrid'],
        ]);

        DB::table('models')->insert([
            ['name' => 'Corolla', 'maker_id' => Maker::inRandomOrder()->first()->id],
            ['name' => 'Camry', 'maker_id' => Maker::inRandomOrder()->first()->id],
            ['name' => 'Accord', 'maker_id' => Maker::inRandomOrder()->first()->id],
            ['name' => 'Mustang', 'maker_id' => Maker::inRandomOrder()->first()->id],
            ['name' => 'Malibu', 'maker_id' => Maker::inRandomOrder()->first()->id],
            ['name' => 'Altima', 'maker_id' => Maker::inRandomOrder()->first()->id],
            ['name' => 'X5', 'maker_id' => Maker::inRandomOrder()->first()->id],
            ['name' => 'C-Class', 'maker_id' => Maker::inRandomOrder()->first()->id],
            ['name' => 'Golf', 'maker_id' => Maker::inRandomOrder()->first()->id],
            ['name' => 'Tucson', 'maker_id' => Maker::inRandomOrder()->first()->id],
            ['name' => 'Civic', 'maker_id' => Maker::inRandomOrder()->first()->id],
            ['name' => 'F-150', 'maker_id' => Maker::inRandomOrder()->first()->id],
            ['name' => 'Silverado', 'maker_id' => Maker::inRandomOrder()->first()->id],
            ['name' => 'Altima', 'maker_id' => Maker::inRandomOrder()->first()->id],
            ['name' => '3 Series', 'maker_id' => Maker::inRandomOrder()->first()->id],
            ['name' => 'C-Class', 'maker_id' => Maker::inRandomOrder()->first()->id],
            ['name' => 'Golf', 'maker_id' => Maker::inRandomOrder()->first()->id],
            ['name' => 'Elantra', 'maker_id' => Maker::inRandomOrder()->first()->id],
            ['name' => 'Soul', 'maker_id' => Maker::inRandomOrder()->first()->id],
        ]);

        DB::table('states')->insert([
            ['name' => 'Alabama'],
            ['name' => 'Alaska'],
            ['name' => 'Arizona'],
            ['name' => 'Arkansas'],
            ['name' => 'California'],
            ['name' => 'Colorado'],
            ['name' => 'Connecticut'],
            ['name' => 'Delaware'],
            ['name' => 'Florida'],
            ['name' => 'Georgia'],
        ]);

        DB::table('cities')->insert([
            ['name' => 'Birmingham', 'state_id' => 1],
            ['name' => 'Montgomery', 'state_id' => 1],
            ['name' => 'Anchorage', 'state_id' => 2],
            ['name' => 'Juneau', 'state_id' => 2],
            ['name' => 'Phoenix', 'state_id' => 3],
            ['name' => 'Tucson', 'state_id' => 3],
            ['name' => 'Little Rock', 'state_id' => 4],
            ['name' => 'Fort Smith', 'state_id' => 4],
            ['name' => 'Los Angeles', 'state_id' => 5],
            ['name' => 'San Francisco', 'state_id' => 5],
            ['name' => 'Denver', 'state_id' => 6],
            ['name' => 'Colorado Springs', 'state_id' => 6],
            ['name' => 'Hartford', 'state_id' => 7],
            ['name' => 'Bridgeport', 'state_id' => 7],
            ['name' => 'Dover', 'state_id' => 8],
            ['name' => 'Wilmington', 'state_id' => 8],
            ['name' => 'Miami', 'state_id' => 9],
            ['name' => 'Orlando', 'state_id' => 9],
            ['name' => 'Atlanta', 'state_id' => 10],
            ['name' => 'Savannah', 'state_id' => 10],
        ]);

        User::factory(10)
            ->has(
                Car::factory(50)
                    ->has(
                        CarImages::factory(5)
                            ->sequence(fn(Sequence $sequence) =>
                            ['position' => $sequence->index % 5 + 1]),
                    )
                    ->hasFeatures()
            )
            ->create();
    }
}
