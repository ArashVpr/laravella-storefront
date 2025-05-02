<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_when_there_is_no_car(): void
    {
        $response = $this->get('/');
        $response->assertOk()->assertSee('No cars found');
    }
    public function test_when_there_are_cars(): void
    {
        // seed the database before testing
        $this->seed();
        $response = $this->get('/');
        $response->assertOk()->assertDontSee('No cars found');
        // assert that the view has a variable named 'cars'
        $response->assertViewHas('cars', function ($cars) {
            return $cars->count() == 30;
        });
    }
}
