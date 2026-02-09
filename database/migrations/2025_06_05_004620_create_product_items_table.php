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
        Schema::create('product_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('excerpt', 50);
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);

            $table->string('image_uri', 50)->nullable();
            $table->string('caption_image', 100)->nullable();

            $table->string('size', 10)->nullable(); // talla ropa
            $table->string('weight', 20)->nullable(); // peso alimentos
            $table->string('color', 20)->nullable(); // color ropa
            $table->enum('unit', ['unidad', 'docena', 'gramos', 'litros'])->nullable(); // unidad de medida
            $table->boolean('state')->default(true);
            $table->boolean('featured')->default(false); // destacado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_items');
    }
};
