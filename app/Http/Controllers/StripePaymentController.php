<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Stripe;
use Stripe\Webhook;

class StripePaymentController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('stripe.secret'));
    }

    /**
     * Create a checkout session for featured listing.
     */
    public function createCheckoutSession(Request $request, Car $car)
    {
        // Verify the user owns the car
        if ($car->user_id !== auth()->id()) {
            abort(403, 'You do not own this car listing.');
        }

        // Check if already featured and not expired
        if ($car->isFeatured()) {
            return back()->with('error', 'This listing is already featured until ' . $car->featured_until->format('M d, Y'));
        }

        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => config('stripe.featured_listing.currency'),
                        'unit_amount' => config('stripe.featured_listing.price'),
                        'product_data' => [
                            'name' => 'Featured Listing',
                            'description' => 'Make your car listing featured for ' . config('stripe.featured_listing.duration_days') . ' days',
                            'images' => [$car->primaryImage?->url ?? 'https://via.placeholder.com/300'],
                        ],
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('car.show', $car),
                'metadata' => [
                    'car_id' => $car->id,
                    'user_id' => auth()->id(),
                    'type' => 'featured_listing',
                ],
            ]);

            // Create a pending payment record
            Payment::create([
                'user_id' => auth()->id(),
                'car_id' => $car->id,
                'stripe_checkout_session_id' => $session->id,
                'stripe_payment_intent_id' => 'pending_' . $session->id, // Will be updated via webhook
                'type' => 'featured_listing',
                'amount' => config('stripe.featured_listing.price'),
                'currency' => config('stripe.featured_listing.currency'),
                'status' => 'pending',
                'metadata' => [
                    'duration_days' => config('stripe.featured_listing.duration_days'),
                ],
            ]);

            return redirect($session->url);
        } catch (\Exception $e) {
            Log::error('Stripe checkout session creation failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to initiate payment. Please try again.');
        }
    }

    /**
     * Handle successful payment.
     */
    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');

        if (!$sessionId) {
            return redirect()->route('home')->with('error', 'Invalid session.');
        }

        try {
            $session = Session::retrieve($sessionId);

            $payment = Payment::where('stripe_checkout_session_id', $sessionId)->first();

            if (!$payment) {
                return redirect()->route('home')->with('error', 'Payment record not found.');
            }

            // If payment is already processed, just show success
            if ($payment->status === 'succeeded') {
                return view('stripe.success', [
                    'payment' => $payment,
                    'car' => $payment->car,
                ]);
            }

            // Update payment status (webhook should have done this, but as a fallback)
            if ($session->payment_status === 'paid') {
                $payment->update([
                    'status' => 'succeeded',
                    'stripe_payment_intent_id' => $session->payment_intent,
                    'paid_at' => now(),
                ]);

                // Mark car as featured
                $payment->car->markAsFeatured(config('stripe.featured_listing.duration_days'));
            }

            return view('stripe.success', [
                'payment' => $payment,
                'car' => $payment->car,
            ]);
        } catch (\Exception $e) {
            Log::error('Stripe success handler failed: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Failed to process payment confirmation.');
        }
    }

    /**
     * Handle Stripe webhooks.
     */
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('stripe.webhook.secret');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                $endpointSecret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            Log::error('Stripe webhook invalid payload: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (SignatureVerificationException $e) {
            // Invalid signature
            Log::error('Stripe webhook invalid signature: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $this->handleCheckoutSessionCompleted($event->data->object);
                break;

            case 'payment_intent.succeeded':
                $this->handlePaymentIntentSucceeded($event->data->object);
                break;

            case 'payment_intent.payment_failed':
                $this->handlePaymentIntentFailed($event->data->object);
                break;

            default:
                Log::info('Unhandled Stripe event type: ' . $event->type);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Handle checkout session completed event.
     */
    private function handleCheckoutSessionCompleted($session)
    {
        Log::info('Checkout session completed', ['session_id' => $session->id]);

        $payment = Payment::where('stripe_checkout_session_id', $session->id)->first();

        if (!$payment) {
            Log::error('Payment not found for session: ' . $session->id);
            return;
        }

        $payment->update([
            'stripe_payment_intent_id' => $session->payment_intent,
        ]);

        if ($session->payment_status === 'paid') {
            $this->markPaymentSucceeded($payment);
        }
    }

    /**
     * Handle payment intent succeeded event.
     */
    private function handlePaymentIntentSucceeded($paymentIntent)
    {
        Log::info('Payment intent succeeded', ['payment_intent_id' => $paymentIntent->id]);

        $payment = Payment::where('stripe_payment_intent_id', $paymentIntent->id)->first();

        if (!$payment) {
            Log::warning('Payment not found for intent: ' . $paymentIntent->id);
            return;
        }

        $this->markPaymentSucceeded($payment);
    }

    /**
     * Handle payment intent failed event.
     */
    private function handlePaymentIntentFailed($paymentIntent)
    {
        Log::info('Payment intent failed', ['payment_intent_id' => $paymentIntent->id]);

        $payment = Payment::where('stripe_payment_intent_id', $paymentIntent->id)->first();

        if (!$payment) {
            Log::warning('Payment not found for intent: ' . $paymentIntent->id);
            return;
        }

        $payment->update([
            'status' => 'failed',
        ]);
    }

    /**
     * Mark payment as succeeded and update car featured status.
     */
    private function markPaymentSucceeded(Payment $payment)
    {
        if ($payment->status === 'succeeded') {
            return; // Already processed
        }

        $payment->update([
            'status' => 'succeeded',
            'paid_at' => now(),
        ]);

        // Mark car as featured
        if ($payment->car) {
            $durationDays = $payment->metadata['duration_days'] ?? config('stripe.featured_listing.duration_days');
            $payment->car->markAsFeatured($durationDays);

            Log::info('Car marked as featured', [
                'car_id' => $payment->car_id,
                'duration_days' => $durationDays,
            ]);
        }
    }
}
