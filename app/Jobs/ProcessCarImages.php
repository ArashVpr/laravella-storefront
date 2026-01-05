<?php

namespace App\Jobs;

use App\Models\Car;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ProcessCarImages implements ShouldQueue
{
    use Queueable;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 10;

    /**
     * Create a new job instance.
     *
     * @param  array<int, string>  $uploadedImages
     */
    public function __construct(
        public Car $car,
        public array $uploadedImages
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("Processing images for car #{$this->car->id}");

        foreach ($this->uploadedImages as $index => $imagePath) {
            try {
                // Store original image
                $originalPath = $imagePath;

                // For future: Add image optimization (resize, compress, WebP conversion)
                // This is a placeholder for image processing logic
                // You can add Intervention Image or Spatie Media Library here

                $this->car->images()->create([
                    'image_path' => $originalPath,
                    'position' => $index + 1,
                ]);

                Log::info("Processed image {$index} for car #{$this->car->id}");
            } catch (\Exception $e) {
                Log::error("Failed to process image {$index} for car #{$this->car->id}: ".$e->getMessage());
                throw $e; // Re-throw to trigger job retry
            }
        }

        Log::info("Completed processing all images for car #{$this->car->id}");
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("Failed to process images for car #{$this->car->id} after all retries: ".$exception->getMessage());

        // Optionally notify the car owner about the failure
        // $this->car->owner->notify(new ImageProcessingFailed($this->car));
    }
}
