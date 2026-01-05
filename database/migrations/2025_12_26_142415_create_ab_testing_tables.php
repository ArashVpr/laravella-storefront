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
        // Experiments table
        Schema::create('ab_experiments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->enum('status', ['draft', 'running', 'paused', 'completed'])->default('draft');
            $table->string('goal')->nullable(); // e.g., 'clicked_cta', 'completed_purchase'
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->json('metadata')->nullable(); // Additional configuration
            $table->timestamps();
            
            $table->index('status');
            $table->index('started_at');
        });

        // Variants table (A, B, C, etc.)
        Schema::create('ab_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('experiment_id')->constrained('ab_experiments')->onDelete('cascade');
            $table->string('name'); // e.g., 'control', 'variant_a', 'variant_b'
            $table->text('description')->nullable();
            $table->integer('traffic_allocation')->default(0); // Percentage 0-100
            $table->boolean('is_control')->default(false);
            $table->json('config')->nullable(); // Variant-specific configuration
            $table->timestamps();
            
            $table->index(['experiment_id', 'name']);
        });

        // User assignments to variants
        Schema::create('ab_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('experiment_id')->constrained('ab_experiments')->onDelete('cascade');
            $table->foreignId('variant_id')->constrained('ab_variants')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('session_id')->nullable(); // For non-authenticated users
            $table->timestamp('assigned_at');
            $table->timestamps();
            
            $table->index(['experiment_id', 'user_id']);
            $table->index(['experiment_id', 'session_id']);
            $table->unique(['experiment_id', 'user_id', 'session_id']);
        });

        // Conversion tracking
        Schema::create('ab_conversions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('experiment_id')->constrained('ab_experiments')->onDelete('cascade');
            $table->foreignId('variant_id')->constrained('ab_variants')->onDelete('cascade');
            $table->foreignId('assignment_id')->constrained('ab_assignments')->onDelete('cascade');
            $table->string('goal'); // What goal was achieved
            $table->decimal('value', 10, 2)->nullable(); // Optional conversion value
            $table->json('metadata')->nullable(); // Additional conversion data
            $table->timestamp('converted_at');
            $table->timestamps();
            
            $table->index(['experiment_id', 'goal']);
            $table->index(['variant_id', 'converted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ab_conversions');
        Schema::dropIfExists('ab_assignments');
        Schema::dropIfExists('ab_variants');
        Schema::dropIfExists('ab_experiments');
    }
};
