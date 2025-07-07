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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('codice_aic', 20)->unique();
            $table->string('cod_farmaco', 20)->nullable();
            $table->string('cod_confezione', 20)->nullable();
            $table->string('denominazione', 255)->nullable();
            $table->string('descrizione', 255)->nullable();
            $table->string('codice_ditta', 20)->nullable();
            $table->string('ragione_sociale', 255)->nullable();
            $table->string('stato_amministrativo', 100)->nullable();
            $table->string('tipo_procedura', 100)->nullable();
            $table->string('forma', 100)->nullable();
            $table->string('codice_atc', 20)->nullable();
            $table->string('pa_associati', 255)->nullable();
            $table->string('link', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
