<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExperienciaLaboralTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('experiencia_laboral', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('cargo');
            $table->string('empresa');
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->text('logros')->nullable();
            $table->json('archivo')->nullable();
            $table->boolean('trabaja_actualmente')->default(false);
            $table->timestamps();

            // Clave FK para la relación con la tabla users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiencia_laboral');
    }
}