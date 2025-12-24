<?php

namespace App\Observers;

use App\Models\NotificationPreference;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // Create default notification preferences for new user
        NotificationPreference::create([
            'user_id' => $user->id,
            // All defaults are set in the migration
        ]);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        // Notification preferences are auto-deleted via cascade
    }
}
