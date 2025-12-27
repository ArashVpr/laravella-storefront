<?php

use App\Models\User;

test('login page loads successfully', function () {
    $response = $this->get('/login');

    $response->assertStatus(200)
        ->assertSee('Login')
        ->assertSee('<a href="'.route('password.forgot').'"', false);
});

test('signup page loads successfully', function () {
    $response = $this->get('/signup');

    $response->assertStatus(200);
});

test('login fails with incorrect credentials', function () {
    User::factory()->create([
        'email' => 'lexi@yahoo.com',
        'password' => bcrypt('password'),
    ]);
    
    $response = $this->post(route('login.store'), [
        'email' => 'lexi@yahoo.com',
        'password' => 'wrong-password',
    ]);

    $response->assertFound()
        ->assertInvalid(['email']);
});

test('login succeeds with correct credentials', function () {
    User::factory()->create([
        'email' => 'lexi@yahoo.com',
        'password' => bcrypt('password'),
    ]);
    
    $response = $this->post(route('login.store'), [
        'email' => 'lexi@yahoo.com',
        'password' => 'password',
    ]);

    $response->assertFound()
        ->assertSessionHas(['success']);
});

test('navbar shows login and signup for guests', function () {
    $response = $this->get('/');

    $response->assertSee('Login')
        ->assertSee('Signup');
});

test('navbar shows logout and user name for authenticated users', function () {
    $this->seed();
    $user = User::first();
    
    $response = $this->actingAs($user)->get('/');

    $response->assertSee('Logout')
        ->assertSee('Welcome, '.$user->name);
});
