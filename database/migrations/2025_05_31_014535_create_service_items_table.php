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
        Schema::create('service_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->string('slug')->unique(); 
            $table->text('description')->nullable();
            $table->string('excerpt', 300)->nullable();
            $table->decimal('price', 11, 2)->default(0);
            $table->text('included');
            $table->string('duration', 50);
            $table->boolean('state')->default(true);

            $table->string('image_uri', 50)->nullable();
            $table->string('caption_image', 100)->nullable();

            $table->string('location', 150)->nullable(); // Punto de encuentro
            $table->unsignedInteger('capacity')->nullable(); // Cupo máximo de personas
            $table->dateTime('start_date')->nullable(); // Inicio de actividad

            $table->boolean('featured')->default(false); // Destacado
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_items');
    }
};
