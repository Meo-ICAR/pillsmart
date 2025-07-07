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
        Schema::table('patients', function (Blueprint $table) {
            $table->time('breakfast_hour')->nullable();
            $table->time('lunch_hour')->nullable();
            $table->time('dinner_hour')->nullable();
            $table->time('wakeup_hour')->nullable();
            $table->time('sleep_hour')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn(['breakfast_hour', 'lunch_hour', 'dinner_hour', 'wakeup_hour', 'sleep_hour']);
        });
    }
};
