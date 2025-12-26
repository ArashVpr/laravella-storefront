<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Laravel\Pennant\Feature;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            \Illuminate\Contracts\Console\Kernel::class,
            \App\Console\Kernel::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('components.pagination');

        // Register observers
        User::observe(UserObserver::class);

        $this->app->resolving(\Illuminate\Console\Command::class, function ($command, $app) {
            $command->setLaravel($app);
        });

        // Define feature flags
        $this->defineFeatureFlags();
    }

    /**
     * Define application feature flags
     */
    protected function defineFeatureFlags(): void
    {
        // Enhanced search with AI-powered suggestions
        Feature::define('enhanced-search', function (?User $user = null) {
            if (!$user) {
                return false;
            }
            return $user->is_premium ?? false;
        });

        // New car listing UI with improved UX
        Feature::define('new-car-ui', function () {
            // Gradual rollout: 50% of requests
            return rand(1, 100) <= 50;
        });

        // Premium watchlist features (unlimited cars, notifications)
        Feature::define('premium-watchlist', function (?User $user = null) {
            if (!$user) {
                return false;
            }
            return $user->is_premium ?? false;
        });

        // Advanced analytics dashboard for sellers
        Feature::define('seller-analytics', function (?User $user = null) {
            if (!$user) {
                return false;
            }
            // Available to users who have listed at least 3 cars
            return $user->cars()->count() >= 3;
        });

        // Real-time chat for car inquiries
        Feature::define('real-time-chat', function () {
            // Feature available globally (enabled for all)
            return true;
        });

        // Image optimization with WebP format
        Feature::define('webp-images', function () {
            // Enabled for all users (already implemented)
            return true;
        });
    }
}
