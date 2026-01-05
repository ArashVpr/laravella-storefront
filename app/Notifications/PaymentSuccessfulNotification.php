<?php

namespace App\Notifications;

use App\Models\Car;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentSuccessfulNotification extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    public function __construct(
        public Payment $payment,
        public Car $car
    ) {}

    public function via(object $notifiable): array
    {
        $channels = [];
        $preferences = $notifiable->notificationPreferences;
        
        if ($preferences?->wantsDatabaseFor('payment_confirmation')) {
            $channels[] = 'database';
        }
        if ($preferences?->wantsEmailFor('payment_confirmation')) {
            $channels[] = 'mail';
        }
        if ($preferences?->wantsPushFor('payment_confirmation')) {
            $channels[] = 'broadcast';
        }
        
        return empty($channels) ? ['database', 'mail', 'broadcast'] : $channels;
    }

    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject('✅ Payment Successful - Featured Listing Active')
            ->greeting('Payment Confirmed!')
            ->line("Your payment for the featured listing has been processed successfully.")
            ->line('**' . $this->car->getTitle() . '**')
            ->line("Amount Paid: {$this->payment->formatted_amount}");
        
        if ($this->car->featured_until) {
            $message->line("Featured Until: " . $this->car->featured_until->format('M d, Y'));
        }
        
        return $message
            ->action('View Your Featured Listing', route('car.show', $this->car))
            ->line('Your listing is now displayed with premium visibility!')
            ->line("Transaction ID: {$this->payment->stripe_payment_intent_id}");
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'payment_successful',
            'payment_id' => $this->payment->id,
            'car_id' => $this->car->id,
            'car_title' => $this->car->getTitle(),
            'amount' => $this->payment->formatted_amount,
            'featured_until' => $this->car->featured_until?->toIso8601String(),
            'url' => route('car.show', $this->car),
            'message' => "Payment successful! {$this->car->getTitle()} is now featured.",
        ];
    }
}
