<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_success_on_login_page(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }
    public function test_success_on_signup_page(): void
    {
        $response = $this->get('/signup');

        $response->assertStatus(200);
    }
    public function test_success_on_forgot_password_page(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
    }
}
