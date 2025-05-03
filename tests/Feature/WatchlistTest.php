<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WatchlistTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_guest_user_cannot_access_watchlist_page(): void
    {
        $response = $this->get('/watchlist');
        $response->assertRedirect('/login');

        $response->assertFound();
    }
    public function test_auth_user_can_access_watchlist_page(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/watchlist');

        $response->assertOk();
    }
}
