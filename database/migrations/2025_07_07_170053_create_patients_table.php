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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date_of_birth')->nullable();
            $table->longText('anamnesi')->nullable()->after('date_of_birth');
            $table->longText('anamnesi_history')->nullable()->after('anamnesi');
            $table->longText('annotations')->nullable()->after('anamnesi_history');
            $table->longText('therapies')->nullable()->after('anamnesi_family');
            $table->time('breakfast_hour')->nullable();
            $table->time('lunch_hour')->nullable();
            $table->time('dinner_hour')->nullable();
            $table->time('wakeup_hour')->nullable();
            $table->time('sleep_hour')->nullable();
            $table->index('user_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
