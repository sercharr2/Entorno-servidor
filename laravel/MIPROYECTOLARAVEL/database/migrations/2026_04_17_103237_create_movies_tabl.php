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
        Schema::create('movies', function (Blueprint $table) {

            $table->id();
            $table->string('title'); // VARCHAR para el título
            $table->year('year'); // Tipo YEAR específico de SQL
            $table->string('director'); // VARCHAR para el nombre del director
            $table->string('poster')->nullable(); // VARCHAR para la ruta de la imagen
            $table->boolean('rented')->default(false); // BOOLEAN (0 o 1)
            $table->text('synopsis'); // TEXT para descripciones largas
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
