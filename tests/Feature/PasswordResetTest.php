<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_success_on_forgot_password_page(): void
    {
        $response = $this->get('/forgot-password');
        $response->assertSee('Request password reset');

        $response->assertOk();
    }

    public function test_incorrect_email_on_forgot_password_page(): void
    {
        User::factory()->create([
            'email' => 'lexi@yahoo.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->get('/forgot-password');
        $response = $this->post(route('password.forgot'), [
            'email' => 'lexi@gmail.com',
        ]);

        $response->assertFound()
            ->assertInvalid(['email']);
    }

    public function test_correct_email_on_forgot_password_page(): void
    {
        User::factory()->create([
            'email' => 'lexi@yahoo.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->get('/forgot-password');
        $response = $this->post(route('password.forgot'), [
            'email' => 'lexi@yahoo.com',
        ]);

        $response->assertFound()
            ->assertSessionHas(['success']);
    }
}
