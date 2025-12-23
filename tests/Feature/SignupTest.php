<?php

namespace Tests\Feature;

use Tests\TestCase;

class SignupTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_signup_functionality(): void
    {
        $response = $this->get('/signup');
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
    }

    public function test_errors_on_signup_page(): void
    {
        $response = $this->get('/signup');
        $response = $this->post(route('signup.store'), [
            'name' => '',
            'email' => 'lexiyahoo.com',
            'phone' => '1234567',
            'password' => 'passworD@%^*12345',
            'password_confirmation' => 'passworD@%^*1234',
        ]);

        $response->assertFound()
            ->assertInvalid(['name', 'email', 'phone', 'password']);

    }

    public function test_email_and_phone_errors_on_signup_page(): void
    {
        $response = $this->get('/signup');
        $response = $this->post(route('signup.store'), [
            'name' => 'Lexi',
            'email' => 'lexiyahoo.com',
            'phone' => '1234567',
            'password' => 'passworD@%^*1234',
            'password_confirmation' => 'passworD@%^*1234',
        ]);

        $response->assertFound()
            ->assertInvalid(['email', 'phone']);

    }

    public function test_empty_field_errors_on_signup_page(): void
    {
        $response = $this->get('/signup');
        $response = $this->post(route('signup.store'), [
            'name' => '',
            'email' => '',
            'phone' => '',
            'password' => '',
            'password_confirmation' => '',
        ]);

        // $response->ddSession();

        $response->assertFound()
            ->assertInvalid(['name', 'email', 'phone', 'password']);
    }
}
