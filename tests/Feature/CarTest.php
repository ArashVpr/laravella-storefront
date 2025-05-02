<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CarTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_redirect_to_login_page_when_accessing_car_create_as_guest_user(): void
    {
        $response = $this->get('/car/create');
        $response->assertRedirect('/login');

        $response->assertStatus(302);

        // $response->ddSession();
        // $response->ddHeaders();
        // $response->dd();

        // $response->dumpSession();
        // $response->dumpHeaders();
        // $response->dump();
    }
    public function test_auth_user_can_access_car_create(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/car/create');

        $response->assertOk()->assertSee('Add new car');
    }
}
