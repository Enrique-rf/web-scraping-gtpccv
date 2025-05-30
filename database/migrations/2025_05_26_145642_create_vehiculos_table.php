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
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->integer('vehiculo_id')->unique();
            $table->string('nombre');
            $table->string('matricula')->unique();
            $table->bigInteger('km_inicial')->default(0);
            $table->bigInteger('km_real')->default(0);
            $table->bigInteger('km_recorridos')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};
