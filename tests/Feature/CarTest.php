<?php

use App\Models\Car;
use App\Models\User;
use Illuminate\Http\UploadedFile;

test('guest user is redirected to login when accessing car create', function () {
    $response = $this->get('/car/create');
    
    $response->assertRedirect('/login')
        ->assertStatus(302);
});

test('authenticated user can access car create page', function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user)->get('/car/create');

    $response->assertOk()
        ->assertSee('List Your Car');
});

test('guest user cannot access my cars page', function () {
    $response = $this->get('/car');
    
    $response->assertRedirect('/login')
        ->assertFound();
});

test('authenticated user can access my cars page', function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user)->get('/car');

    $response->assertOk();
});

test('authenticated user can create a car with images and features', function () {
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

    // Verify features are added to the database
    $addedCar = Car::latest('id')->first();
    $features['car_id'] = $addedCar->id;
    $this->assertDatabaseHas('car_features', $features);

    // Verify car is added to the database
    unset($carData['features']);
    unset($carData['images']);
    $this->assertDatabaseHas('cars', $carData);
});

test('car creation shows validation errors for invalid data', function () {
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
            'power_windows' => '1',
        ],
    ]);

    $response->assertFound()
        ->assertInvalid(['year']);
});

test('car creation shows errors for all empty required fields', function () {
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
            'power_windows' => '1',
        ],
    ]);

    $response->assertFound()
        ->assertInvalid(['maker_id', 'model_id', 'year', 'car_type_id', 'price', 'vin', 'mileage', 'fuel_type_id', 'city_id', 'address', 'phone']);
});

test('authenticated user can update their car', function () {
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

    $carData['id'] = $firstCar->id;
});

test('authenticated user can delete their car', function () {
    $this->seed();
    $user = User::first();
    $firstCar = $user->cars()->first();

    $response = $this->actingAs($user)->delete(route('car.destroy', $firstCar));

    $response->assertFound()
        ->assertRedirectToRoute('car.index')
        ->assertSessionHas(['success']);
});

test('user cannot access another users car for editing', function () {
    $this->seed();
    $userOneCar = User::find(1)->cars()->first();
    $userTwo = User::find(2);
    
    $response = $this->actingAs($userTwo)->get(route('car.edit', $userOneCar));

    $response->assertForbidden();
});
