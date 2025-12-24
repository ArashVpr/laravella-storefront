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
        Schema::table('cars', function (Blueprint $table) {
            $table->boolean('is_featured')->default(false)->after('description');
            $table->timestamp('featured_until')->nullable()->after('is_featured');
            $table->index('is_featured');
            $table->index('featured_until');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['featured_until']);
            $table->dropColumn(['is_featured', 'featured_until']);
        });
    }
};
