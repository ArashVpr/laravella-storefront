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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('car_id')->nullable()->constrained()->onDelete('set null');
            $table->string('stripe_payment_intent_id')->unique();
            $table->string('stripe_checkout_session_id')->nullable()->unique();
            $table->string('type'); // 'featured_listing', 'premium_subscription', etc.
            $table->integer('amount'); // in cents
            $table->string('currency', 3)->default('usd');
            $table->string('status'); // 'pending', 'succeeded', 'failed', 'refunded'
            $table->text('metadata')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'created_at']);
            $table->index('status');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
