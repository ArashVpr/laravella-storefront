<?php

namespace App\Jobs;

use App\Models\Car;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendCarCreatedNotification implements ShouldQueue
{
    use Queueable;

    public $tries = 3;

    public $backoff = 5;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Car $car
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("Sending car created notification for car #{$this->car->id}");

        // Email notification to car owner
        // Mail::to($this->car->owner->email)->send(new CarCreated($this->car));

        // For now, just log it (since mail is configured as 'log' driver)
        Log::info("Car created notification sent to {$this->car->owner->email} for car: {$this->car->title}");

        // Future: Send SMS, push notifications, etc.
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("Failed to send car created notification for car #{$this->car->id}: ".$exception->getMessage());
    }
}
