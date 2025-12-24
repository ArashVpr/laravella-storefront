<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'car_id' => \App\Models\Car::factory(),
            'stripe_payment_intent_id' => 'pi_' . fake()->uuid(),
            'stripe_checkout_session_id' => 'cs_' . fake()->uuid(),
            'type' => 'featured_listing',
            'amount' => 2999,
            'currency' => 'usd',
            'status' => 'completed',
            'metadata' => [
                'featured_duration_days' => 30,
            ],
            'paid_at' => now(),
        ];
    }
}
