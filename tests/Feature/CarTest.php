<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Contracts\Auth\Authenticatable;
use Tests\TestCase;

class CarTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_redirect_to_login_page_when_accessing_car_create_as_guest_user(): void
    {
        $response = $this->get('/car/create');
        $response->assertRedirect('/login');

        $response->assertStatus(302);
    }
    public function test_auth_user_can_access_car_create(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/car/create');

        $response->assertOk()->assertSee('Add new car');
    }

    public function test_guest_user_cannot_access_my_cars_page(): void
    {
        $response = $this->get('/car');
        $response->assertRedirect('/login');

        $response->assertFound();
    }
    public function test_auth_user_can_access_my_cars_page(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/car');

        $response->assertOk();
    }
    public function test_create_car_functionality(): void
    {
        $this->seed();
        $user = User::factory()->create();
        $images = [
            UploadedFile::fake()->image('1.jpg'),
            UploadedFile::fake()->image('2.jpg'),
            UploadedFile::fake()->image('3.jpg'),
            UploadedFile::fake()->image('4.jpg'),
            UploadedFile::fake()->image('5.jpg'),
        ];

        $features = [
            'air_conditioning' => '1',
            'power_windows' => '1',
        ];

        $carData = [
            'maker_id' => '1',
            'model_id' => '1',
            'year' => '2023',
            'car_type_id' => '1',
            'price' => '10000',
            'vin' => '12345678901234567',
            'mileage' => '10000',
            'fuel_type_id' => '1',
            'city_id' => '1',
            'address' => '123 Main St',
            'phone' => '1234567890',
            'description' => 'This is a test car',
            'published_at' => '2023-10-01',
            'features' => $features,
            'images' => $images,
        ];

        $response = $this->actingAs($user)->post(route('car.store'), $carData);

        $response->assertFound()
            ->assertRedirectToRoute('car.index')
            ->assertSessionHas(['success']);

        // to check if the car_id is added to the features table
        $addedCar = Car::latest('id')->first();
        $features['car_id'] = $addedCar->id;
        $this->assertDatabaseHas('car_features', $features);

        // to check if the car is added to the user table
        unset($carData['features']);
        unset($carData['images']);
        $this->assertDatabaseHas('cars', $carData);
    }
    public function test_create_car_errors(): void
    {
        $user = User::factory()->create();
        $this->seed();
        $response = $this->actingAs($user)->post(route('car.store'), [
            'maker_id' => '1',
            'model_id' => '1',
            'year' => '',
            'car_type_id' => '1',
            'price' => '10000',
            'vin' => '12345678901234567',
            'mileage' => '10000',
            'fuel_type_id' => '1',
            'city_id' => '1',
            'address' => '123 Main St',
            'phone' => '1234567890',
            'description' => 'This is a test car',
            'published_at' => '2023-10-01',
            'features' => [
                'air_conditioning' => '1',
                'power_windows' => '1'
            ],
            // 'images' => ['image1.jpg','image2.jpg'],
        ]);

        // $response->ddSession();
        $response->assertFound()
            ->assertInvalid(['year']);
    }
    public function test_create_car_empty_field_errors(): void
    {
        $user = User::factory()->create();
        $this->seed();
        $response = $this->actingAs($user)->post(route('car.store'), [
            'maker_id' => '',
            'model_id' => '',
            'year' => '',
            'car_type_id' => '',
            'price' => '',
            'vin' => '',
            'mileage' => '',
            'fuel_type_id' => '',
            'city_id' => '',
            'address' => '',
            'phone' => '',
            'description' => '',
            'published_at' => '',
            'features' => [
                'air_conditioning' => '1',
                'power_windows' => '1'
            ],
            // 'images' => ['image1.jpg','image2.jpg'],
        ]);

        // $response->ddSession();
        $response->assertFound()
            ->assertInvalid(['maker_id', 'model_id', 'year', 'car_type_id', 'price', 'vin', 'mileage', 'fuel_type_id', 'city_id', 'address', 'phone']);
    }

    public function test_update_car_functionality(): void
    {
        $this->seed();
        $user = User::first();
        $firstCar = $user->cars()->first();

        $features = [
            'air_conditioning' => '1',
            'power_windows' => '1',
        ];

        $carData = [
            'maker_id' => '1',
            'model_id' => '1',
            'year' => '2023',
            'car_type_id' => '1',
            'price' => '10000',
            'vin' => '12345678901234567',
            'mileage' => '10000',
            'fuel_type_id' => '1',
            'city_id' => '1',
            'address' => '123 Main St',
            'phone' => '1234567890',
            'description' => 'This is a test car',
            'published_at' => '2023-10-01',
            'features' => $features,
        ];

        $response = $this->actingAs($user)->put(route('car.update', $firstCar), $carData);

        $response->assertFound()
            ->assertRedirectToRoute('car.index')
            ->assertSessionHas(['success']);

        // to check if the car_id is updated
        $carData['id'] = $firstCar->id;

    }
    public function test_delete_car_functionality(): void
    {
        $this->seed();
        $user = User::first();
        $firstCar = $user->cars()->first();

        $response = $this->actingAs($user)->delete(route('car.destroy', $firstCar));

        $response->assertFound()
            ->assertRedirectToRoute('car.index')
            ->assertSessionHas(['success']);
    }
    
    public function test_access_forbidden_to_someone_else_car(): void
    {
        $this->seed();
        $userOneCar = User::find(1)->cars()->first(); 
        $userTwo = User::find(2);
        $response = $this->actingAs($userTwo)->get(route('car.edit', $userOneCar));

        $response->assertForbidden();
    }
    
}
