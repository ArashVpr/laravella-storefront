<?php

namespace Tests\Feature;

use App\Models\User;
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

        $response->assertStatus(200)
        ->assertSee('Login')
        ->assertSee('<a href="'. route('password.forgot').'"', false);
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
    public function test_incorrect_credentials_on_login_page(): void
    {
        User::factory()->create([
            'email' => 'lexi@yahoo.com',
            'password' => bcrypt('password'),
        ]);
        $response = $this->post(route('login.store'), [
            'email' => 'lexi@yahoo.com',
            'password' => 'wrong-password',
        ]);

        $response->assertFound()
        // ->assertSessionHasErrors(['email'])
        ->assertInvalid(['email']);
    }
    public function test_correct_credentials_on_login_page(): void
    {
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
    }



}
