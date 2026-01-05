<?php

use App\Models\User;

test('forgot password page loads successfully', function () {
    $response = $this->get('/forgot-password');
    
    $response->assertOk()
        ->assertSee('password', false);
});

test('forgot password fails with incorrect email', function () {
    User::factory()->create([
        'email' => 'lexi@yahoo.com',
        'password' => bcrypt('password'),
    ]);

    $this->get('/forgot-password');
    $response = $this->post(route('password.forgot'), [
        'email' => 'lexi@gmail.com',
    ]);

    $response->assertFound()
        ->assertInvalid(['email']);
});

test('forgot password succeeds with correct email', function () {
    User::factory()->create([
        'email' => 'lexi@yahoo.com',
        'password' => bcrypt('password'),
    ]);

    $this->get('/forgot-password');
    $response = $this->post(route('password.forgot'), [
        'email' => 'lexi@yahoo.com',
    ]);

    $response->assertFound()
        ->assertSessionHas(['success']);
});
