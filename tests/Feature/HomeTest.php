<?php

test('home page loads successfully when database is empty', function () {
    $response = $this->get('/');

    $response->assertOk()
        ->assertSee('Latest Arrivals');
});

test('home page shows cars when database has data', function () {
    $this->seed();
    $response = $this->get('/');
    
    $response->assertOk()
        ->assertDontSee('No cars found')
        ->assertViewHas('cars', function ($cars) {
            return $cars->count() > 0;
        })
        ->assertViewHas('featuredCars');
});
