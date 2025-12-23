<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_guest_user_cannot_access_profile_page(): void
    {
        $response = $this->get('/profile');
        $response->assertRedirect('/login');

        $response->assertFound();
    }

    public function test_auth_user_can_access_profile_page(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/profile');

        $response->assertOk();
    }
}
