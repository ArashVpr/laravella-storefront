<?php

use function Pest\Laravel\get;
use function Pest\Laravel\seed;

it('displays "No cars found" when database is empty', function () {
    get('/')
        ->assertOk()
        ->assertSee('No cars found');
});

it('displays cars when database has listings', function () {
    seed();

    get('/')
        ->assertOk()
        ->assertDontSee('No cars found')
        ->assertViewHas('cars', fn ($cars) => $cars->count() === 30);
});
