<?php

test('home page shows no cars message when database is empty', function () {
    $response = $this->get('/');
    
    $response->assertOk()
        ->assertSee('No cars found');
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
