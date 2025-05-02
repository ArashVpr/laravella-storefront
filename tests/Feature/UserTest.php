<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_redirect_to_profile_page_when_accessing_car_create_as_guest_user(): void
    {
        $response = $this->get('/profile');
        $response->assertRedirect('/login');

        $response->assertStatus(302);
    }
}
