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
        Schema::table('car_images', function (Blueprint $table) {
            // Drop existing foreign key and recreate with cascade
            if (Schema::hasColumn('car_images', 'car_id')) {
                // Use raw drop to be safe with constraint names
                try {
                    $table->dropForeign(['car_id']);
                } catch (\Exception $e) {
                    // ignore if it doesn't exist
                }

                $table->foreign('car_id')
                    ->references('id')
                    ->on('cars')
                    ->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_images', function (Blueprint $table) {
            try {
                $table->dropForeign(['car_id']);
            } catch (\Exception $e) {
                // ignore
            }

            $table->foreign('car_id')
                ->references('id')
                ->on('cars');
        });
    }
};
