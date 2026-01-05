<?php

use App\Models\User;

test('guest user cannot access profile page', function () {
    $response = $this->get('/profile');
    
    $response->assertRedirect('/login')
        ->assertFound();
});

test('authenticated user can access profile page', function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user)->get('/profile');

    $response->assertOk();
});
