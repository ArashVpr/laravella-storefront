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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignid('maker_id')->constrained('makers')->onDelete('cascade');
            $table->foreignid('model_id')->constrained('models')->onDelete('cascade');
            $table->integer('year');
            $table->integer('price');
            $table->integer('mileage');
            $table->string('vin');
            $table->foreignid('car_type_id')->constrained('car_types')->onDelete('cascade');
            $table->foreignid('fuel_type_id')->constrained('fuel_types')->onDelete('cascade');
            $table->foreignid('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignid('city_id')->constrained('cities')->onDelete('cascade');
            $table->string('address');
            $table->string('phone', 45);
            $table->longText('description')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
