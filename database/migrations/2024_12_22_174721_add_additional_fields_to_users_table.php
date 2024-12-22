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
        Schema::table('users', function (Blueprint $table) {
            $table->string('rango_salarial')->nullable();
            $table->string('nivel_profesional')->nullable();
            $table->string('nombre_completo')->nullable();
            $table->string('profesion')->nullable();
            $table->string('especializacion')->nullable();
            $table->unsignedBigInteger('numero_documento')->nullable();
            $table->string('ciudad_de_empleo')->nullable();
            $table->boolean('traslado')->default(false);
            $table->string('celular')->nullable();
            $table->string('linkedin')->nullable();
            $table->text('valor_agregado')->nullable(); // Text area
            $table->string('feliz_en_la_labor')->nullable();
            $table->string('talento_profesional')->nullable();
            $table->string('ideas')->nullable();
            $table->string('datos_complementarios')->nullable();
            $table->string('competencias')->nullable();
            $table->string('tipo_cultura')->nullable();
            $table->string('jornada')->nullable();
            $table->string('tipo_formacion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'rango_salarial',
                'nivel_profesional',
                'nombre_completo',
                'profesion',
                'especializacion',
                'numero_documento',
                'ciudad_de_empleo',
                'traslado',
                'celular',
                'linkedin',
                'valor_agregado',
                'feliz_en_la_labor',
                'talento_profesional',
                'ideas',
                'datos_complementarios',
                'competencias',
                'tipo_cultura',
                'jornada',
                'tipo_formacion',
            ]);
        });
    }
};