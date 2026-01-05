<?php

namespace App\Notifications;

use App\Models\Car;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCarInquiryNotification extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    public function __construct(
        public Car $car,
        public string $inquirerName,
        public string $inquirerEmail,
        public string $message
    ) {}

    public function via(object $notifiable): array
    {
        $channels = [];
        $preferences = $notifiable->notificationPreferences;
        
        if ($preferences?->wantsDatabaseFor('car_inquiry')) {
            $channels[] = 'database';
        }
        if ($preferences?->wantsEmailFor('car_inquiry')) {
            $channels[] = 'mail';
        }
        if ($preferences?->wantsPushFor('car_inquiry')) {
            $channels[] = 'broadcast';
        }
        
        return empty($channels) ? ['database', 'mail', 'broadcast'] : $channels;
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('💬 New Inquiry About Your Car')
            ->greeting('New Message!')
            ->line("Someone is interested in your car listing!")
            ->line('**' . $this->car->getTitle() . '**')
            ->line("From: {$this->inquirerName} ({$this->inquirerEmail})")
            ->line("Message:")
            ->line($this->message)
            ->action('View Car & Reply', route('car.show', $this->car))
            ->line('Respond quickly to close the deal!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'car_inquiry',
            'car_id' => $this->car->id,
            'car_title' => $this->car->getTitle(),
            'inquirer_name' => $this->inquirerName,
            'inquirer_email' => $this->inquirerEmail,
            'message' => $this->message,
            'url' => route('car.show', $this->car),
            'message' => "New inquiry about {$this->car->getTitle()} from {$this->inquirerName}",
        ];
    }
}
