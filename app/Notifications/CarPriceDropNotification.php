<?php

namespace App\Notifications;

use App\Models\Car;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CarPriceDropNotification extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    public function __construct(
        public Car $car,
        public float $oldPrice,
        public float $newPrice
    ) {}

    public function via(object $notifiable): array
    {
        $channels = [];
        $preferences = $notifiable->notificationPreferences;
        
        if ($preferences?->wantsDatabaseFor('price_drop')) {
            $channels[] = 'database';
        }
        if ($preferences?->wantsEmailFor('price_drop')) {
            $channels[] = 'mail';
        }
        if ($preferences?->wantsPushFor('price_drop')) {
            $channels[] = 'broadcast';
        }
        
        return empty($channels) ? ['database', 'broadcast'] : $channels;
    }

    public function toMail(object $notifiable): MailMessage
    {
        $priceDrop = $this->oldPrice - $this->newPrice;
        $percentDrop = round(($priceDrop / $this->oldPrice) * 100, 1);

        return (new MailMessage)
            ->subject('💰 Price Drop Alert: ' . $this->car->getTitle())
            ->greeting('Great News!')
            ->line("A car in your watchlist just dropped in price!")
            ->line('**' . $this->car->getTitle() . '**')
            ->line("Old Price: $" . number_format($this->oldPrice))
            ->line("New Price: $" . number_format($this->newPrice))
            ->line("You save: $" . number_format($priceDrop) . " ({$percentDrop}% off)")
            ->action('View Car', route('car.show', $this->car))
            ->line('Act fast before someone else gets this deal!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'price_drop',
            'car_id' => $this->car->id,
            'car_title' => $this->car->getTitle(),
            'old_price' => $this->oldPrice,
            'new_price' => $this->newPrice,
            'savings' => $this->oldPrice - $this->newPrice,
            'url' => route('car.show', $this->car),
            'message' => "Price dropped on {$this->car->getTitle()}: $" . number_format($this->oldPrice) . " → $" . number_format($this->newPrice),
        ];
    }

    public function toBroadcast(object $notifiable): array
    {
        return $this->toArray($notifiable);
    }
}
