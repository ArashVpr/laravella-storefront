<?php

test('signup functionality works correctly', function () {
    $this->get('/signup');
    
    $response = $this->post(route('signup.store'), [
        'name' => 'Lexi',
        'email' => 'lexi@yahoo.com',
        'phone' => '12345678',
        'password' => 'passworD@%^*1234',
        'password_confirmation' => 'passworD@%^*1234',
    ]);

    $response->assertFound()
        ->assertRedirectToRoute('homepage')
        ->assertSessionHas(['success']);
});

test('signup shows validation errors for invalid data', function () {
    $this->get('/signup');
    
    $response = $this->post(route('signup.store'), [
        'name' => '',
        'email' => 'lexiyahoo.com',
        'phone' => '1234567',
        'password' => 'passworD@%^*12345',
        'password_confirmation' => 'passworD@%^*1234',
    ]);

    $response->assertFound()
        ->assertInvalid(['name', 'email', 'phone', 'password']);
});

test('signup shows errors for invalid email and phone', function () {
    $this->get('/signup');
    
    $response = $this->post(route('signup.store'), [
        'name' => 'Lexi',
        'email' => 'lexiyahoo.com',
        'phone' => '1234567',
        'password' => 'passworD@%^*1234',
        'password_confirmation' => 'passworD@%^*1234',
    ]);

    $response->assertFound()
        ->assertInvalid(['email', 'phone']);
});

test('signup shows errors for empty fields', function () {
    $this->get('/signup');
    
    $response = $this->post(route('signup.store'), [
        'name' => '',
        'email' => '',
        'phone' => '',
        'password' => '',
        'password_confirmation' => '',
    ]);

    $response->assertFound()
        ->assertInvalid(['name', 'email', 'phone', 'password']);
});
