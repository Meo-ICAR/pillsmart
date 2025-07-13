<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('mac')->nullable();
            $table->integer('nslots')->nullable();
            $table->tinyText('annotations')->nullable();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->boolean('istoupdate')->default(0);
            $table->dateTime('updated_at')->nullable();
            $table->timestamp('pinged_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('modified_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->index('patient_id');
            // You may want to add a foreign key constraint if patients table exists:
            // $table->foreign('patient_id')->references('id')->on('patients')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
