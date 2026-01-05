<?php

namespace App\Notifications;

use App\Models\Car;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WatchlistCarUpdatedNotification extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    public function __construct(
        public Car $car,
        public string $updateType,
        public array $changes = []
    ) {}

    public function via(object $notifiable): array
    {
        $channels = [];
        $preferences = $notifiable->notificationPreferences;
        
        if ($preferences?->wantsDatabaseFor('watchlist_update')) {
            $channels[] = 'database';
        }
        if ($preferences?->wantsEmailFor('watchlist_update')) {
            $channels[] = 'mail';
        }
        if ($preferences?->wantsPushFor('watchlist_update')) {
            $channels[] = 'broadcast';
        }
        
        return empty($channels) ? ['database', 'broadcast'] : $channels;
    }

    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject('📝 Update on Your Watched Car')
            ->greeting('Watchlist Update')
            ->line("A car in your watchlist has been updated!")
            ->line('**' . $this->car->getTitle() . '**');

        if (!empty($this->changes)) {
            $message->line('**Changes:**');
            foreach ($this->changes as $field => $change) {
                $message->line("• {$field}: {$change['from']} → {$change['to']}");
            }
        }

        return $message
            ->action('View Car', route('car.show', $this->car))
            ->line('Stay updated on your favorite listings!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'watchlist_update',
            'car_id' => $this->car->id,
            'car_title' => $this->car->getTitle(),
            'update_type' => $this->updateType,
            'changes' => $this->changes,
            'url' => route('car.show', $this->car),
            'message' => "{$this->car->getTitle()} has been updated.",
        ];
    }
}
