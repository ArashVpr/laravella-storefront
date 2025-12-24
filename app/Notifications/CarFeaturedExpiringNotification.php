<?php

namespace App\Notifications;

use App\Models\Car;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CarFeaturedExpiringNotification extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    public function __construct(
        public Car $car,
        public int $daysRemaining
    ) {}

    public function via(object $notifiable): array
    {
        $channels = [];
        $preferences = $notifiable->notificationPreferences;
        
        if ($preferences?->wantsDatabaseFor('featured_expiring')) {
            $channels[] = 'database';
        }
        if ($preferences?->wantsEmailFor('featured_expiring')) {
            $channels[] = 'mail';
        }
        if ($preferences?->wantsPushFor('featured_expiring')) {
            $channels[] = 'broadcast';
        }
        
        return empty($channels) ? ['database', 'mail', 'broadcast'] : $channels;
    }

    public function toMail(object $notifiable): MailMessage
    {
        $daysText = $this->daysRemaining === 1 ? '1 day' : "{$this->daysRemaining} days";
        
        $message = (new MailMessage)
            ->subject('⏰ Featured Listing Expiring Soon')
            ->greeting('Heads Up!')
            ->line("Your featured listing is expiring in {$daysText}.")
            ->line('**' . $this->car->getTitle() . '**');
        
        if ($this->car->featured_until) {
            $message->line("Expires on: " . $this->car->featured_until->format('M d, Y'));
        }
        
        return $message
            ->line("Want to extend your premium visibility?")
            ->action('Renew Featured Status', route('stripe.checkout', $this->car))
            ->line("Don't miss out on potential buyers!");
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'featured_expiring',
            'car_id' => $this->car->id,
            'car_title' => $this->car->getTitle(),
            'days_remaining' => $this->daysRemaining,
            'expires_at' => $this->car->featured_until?->toIso8601String(),
            'url' => route('car.show', $this->car),
            'renew_url' => route('stripe.checkout', $this->car),
            'message' => "Your featured listing for {$this->car->getTitle()} expires in " . 
                         ($this->daysRemaining === 1 ? '1 day' : "{$this->daysRemaining} days") . ".",
        ];
    }
}
