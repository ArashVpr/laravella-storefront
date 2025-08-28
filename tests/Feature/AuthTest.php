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
    public function test_navbar_as_guest(): void
    {
        $response = $this->get('/');

        $response->assertSee('Login')
        ->assertSee('Signup');
    }
    public function test_navbar_as_user(): void
    {
        $this->seed();
        $user = User::first();
        $response = $this->actingAs($user)->get('/');

        $response->assertSee('Logout')
        ->assertSee("Welcome, " . $user->name);
    }
}
