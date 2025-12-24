<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationPreference extends Model
{
    protected $fillable = [
        'user_id',
        // Email
        'email_new_car_listing',
        'email_price_drop',
        'email_watchlist_update',
        'email_payment_confirmation',
        'email_car_inquiry',
        'email_featured_expiring',
        'email_weekly_digest',
        // Database
        'database_new_car_listing',
        'database_price_drop',
        'database_watchlist_update',
        'database_payment_confirmation',
        'database_car_inquiry',
        'database_featured_expiring',
        // Push
        'push_enabled',
        'push_new_car_listing',
        'push_price_drop',
        'push_watchlist_update',
        'push_car_inquiry',
    ];

    protected $casts = [
        'email_new_car_listing' => 'boolean',
        'email_price_drop' => 'boolean',
        'email_watchlist_update' => 'boolean',
        'email_payment_confirmation' => 'boolean',
        'email_car_inquiry' => 'boolean',
        'email_featured_expiring' => 'boolean',
        'email_weekly_digest' => 'boolean',
        'database_new_car_listing' => 'boolean',
        'database_price_drop' => 'boolean',
        'database_watchlist_update' => 'boolean',
        'database_payment_confirmation' => 'boolean',
        'database_car_inquiry' => 'boolean',
        'database_featured_expiring' => 'boolean',
        'push_enabled' => 'boolean',
        'push_new_car_listing' => 'boolean',
        'push_price_drop' => 'boolean',
        'push_watchlist_update' => 'boolean',
        'push_car_inquiry' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if user wants email notifications for a specific event
     */
    public function wantsEmailFor(string $event): bool
    {
        $key = "email_{$event}";
        return $this->$key ?? false;
    }

    /**
     * Check if user wants database notifications for a specific event
     */
    public function wantsDatabaseFor(string $event): bool
    {
        $key = "database_{$event}";
        return $this->$key ?? false;
    }

    /**
     * Check if user wants push notifications for a specific event
     */
    public function wantsPushFor(string $event): bool
    {
        if (!$this->push_enabled) {
            return false;
        }
        $key = "push_{$event}";
        return $this->$key ?? false;
    }
}
