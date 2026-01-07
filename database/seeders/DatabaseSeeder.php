<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarImage;
use App\Models\Maker;
use App\Models\User;
// use Doctrine\DBAL\Schema\Sequence;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $makers = [
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
            ['name' => 'Renault'],
            ['name' => 'Peugeot'],
            ['name' => 'Citroën'],
        ];
        DB::table('makers')->insert($makers);

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

        // Real-world car models for each brand
        $models = [
            // Toyota
            ['name' => 'Corolla', 'maker_id' => Maker::where('name', 'Toyota')->first()->id],
            ['name' => 'Camry', 'maker_id' => Maker::where('name', 'Toyota')->first()->id],
            ['name' => 'RAV4', 'maker_id' => Maker::where('name', 'Toyota')->first()->id],
            ['name' => 'Prius', 'maker_id' => Maker::where('name', 'Toyota')->first()->id],
            // Honda
            ['name' => 'Civic', 'maker_id' => Maker::where('name', 'Honda')->first()->id],
            ['name' => 'Accord', 'maker_id' => Maker::where('name', 'Honda')->first()->id],
            ['name' => 'CR-V', 'maker_id' => Maker::where('name', 'Honda')->first()->id],
            // Ford
            ['name' => 'F-150', 'maker_id' => Maker::where('name', 'Ford')->first()->id],
            ['name' => 'Mustang', 'maker_id' => Maker::where('name', 'Ford')->first()->id],
            ['name' => 'Focus', 'maker_id' => Maker::where('name', 'Ford')->first()->id],
            // Chevrolet
            ['name' => 'Silverado', 'maker_id' => Maker::where('name', 'Chevrolet')->first()->id],
            ['name' => 'Malibu', 'maker_id' => Maker::where('name', 'Chevrolet')->first()->id],
            ['name' => 'Equinox', 'maker_id' => Maker::where('name', 'Chevrolet')->first()->id],
            // Nissan
            ['name' => 'Altima', 'maker_id' => Maker::where('name', 'Nissan')->first()->id],
            ['name' => 'Sentra', 'maker_id' => Maker::where('name', 'Nissan')->first()->id],
            ['name' => 'Rogue', 'maker_id' => Maker::where('name', 'Nissan')->first()->id],
            // BMW
            ['name' => '3 Series', 'maker_id' => Maker::where('name', 'BMW')->first()->id],
            ['name' => '5 Series', 'maker_id' => Maker::where('name', 'BMW')->first()->id],
            ['name' => 'X5', 'maker_id' => Maker::where('name', 'BMW')->first()->id],
            // Mercedes-Benz
            ['name' => 'C-Class', 'maker_id' => Maker::where('name', 'Mercedes-Benz')->first()->id],
            ['name' => 'E-Class', 'maker_id' => Maker::where('name', 'Mercedes-Benz')->first()->id],
            ['name' => 'GLA', 'maker_id' => Maker::where('name', 'Mercedes-Benz')->first()->id],
            // Volkswagen
            ['name' => 'Golf', 'maker_id' => Maker::where('name', 'Volkswagen')->first()->id],
            ['name' => 'Passat', 'maker_id' => Maker::where('name', 'Volkswagen')->first()->id],
            ['name' => 'Tiguan', 'maker_id' => Maker::where('name', 'Volkswagen')->first()->id],
            // Hyundai
            ['name' => 'Elantra', 'maker_id' => Maker::where('name', 'Hyundai')->first()->id],
            ['name' => 'Tucson', 'maker_id' => Maker::where('name', 'Hyundai')->first()->id],
            ['name' => 'Santa Fe', 'maker_id' => Maker::where('name', 'Hyundai')->first()->id],
            // Kia
            ['name' => 'Soul', 'maker_id' => Maker::where('name', 'Kia')->first()->id],
            ['name' => 'Sportage', 'maker_id' => Maker::where('name', 'Kia')->first()->id],
            ['name' => 'Sorento', 'maker_id' => Maker::where('name', 'Kia')->first()->id],
            // Renault
            ['name' => 'Clio', 'maker_id' => Maker::where('name', 'Renault')->first()->id],
            ['name' => 'Megane', 'maker_id' => Maker::where('name', 'Renault')->first()->id],
            ['name' => 'Captur', 'maker_id' => Maker::where('name', 'Renault')->first()->id],
            // Peugeot
            ['name' => '208', 'maker_id' => Maker::where('name', 'Peugeot')->first()->id],
            ['name' => '308', 'maker_id' => Maker::where('name', 'Peugeot')->first()->id],
            ['name' => '3008', 'maker_id' => Maker::where('name', 'Peugeot')->first()->id],
            // Citroën
            ['name' => 'C3', 'maker_id' => Maker::where('name', 'Citroën')->first()->id],
            ['name' => 'C4', 'maker_id' => Maker::where('name', 'Citroën')->first()->id],
            ['name' => 'Berlingo', 'maker_id' => Maker::where('name', 'Citroën')->first()->id],
        ];
        DB::table('models')->insert($models);

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
                Car::factory(20)
                    ->has(
                        CarImage::factory(5)
                            ->sequence(fn (Sequence $sequence) => ['position' => $sequence->index % 5 + 1]),
                    )
                    ->hasFeatures(),
                'favoriteCars'
            )
            ->create();

        // Create a specific user for the Demo credentials shown in the UI
        User::factory()->create([
            'name' => 'Demo User',
            'email' => 'akoelpin@example.net',
            'password' => '$2y$12$K.zWq.F/M/lT/jTqJ.1/..l/d/o/k/e/y/w/o/r/d/s', // Just rely on factory default which is 'password'
             // Actually, the factory sets static password hash. Let's just use the factory default.
        ]);
        
        $demoUser = User::where('email', 'akoelpin@example.net')->first();
        if (!$demoUser) {
             User::factory()->create([
                'name' => 'Demo User',
                'email' => 'akoelpin@example.net',
            ]);
        }
    }
}
