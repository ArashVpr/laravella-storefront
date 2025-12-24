<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notification_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Email Notifications
            $table->boolean('email_new_car_listing')->default(true);
            $table->boolean('email_price_drop')->default(true);
            $table->boolean('email_watchlist_update')->default(true);
            $table->boolean('email_payment_confirmation')->default(true);
            $table->boolean('email_car_inquiry')->default(true);
            $table->boolean('email_featured_expiring')->default(true);
            $table->boolean('email_weekly_digest')->default(false);
            
            // Database/In-App Notifications
            $table->boolean('database_new_car_listing')->default(true);
            $table->boolean('database_price_drop')->default(true);
            $table->boolean('database_watchlist_update')->default(true);
            $table->boolean('database_payment_confirmation')->default(true);
            $table->boolean('database_car_inquiry')->default(true);
            $table->boolean('database_featured_expiring')->default(true);
            
            // Push Notifications (Browser/Mobile)
            $table->boolean('push_enabled')->default(false);
            $table->boolean('push_new_car_listing')->default(false);
            $table->boolean('push_price_drop')->default(true);
            $table->boolean('push_watchlist_update')->default(true);
            $table->boolean('push_car_inquiry')->default(true);
            
            $table->timestamps();
            
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_preferences');
    }
};
