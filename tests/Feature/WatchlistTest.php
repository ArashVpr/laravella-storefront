<?php

use App\Models\User;

test('guest user cannot access watchlist page', function () {
    $response = $this->get('/watchlist');
    
    $response->assertRedirect('/login')
        ->assertFound();
});

test('authenticated user can access watchlist page', function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user)->get('/watchlist');

    $response->assertOk();
});
