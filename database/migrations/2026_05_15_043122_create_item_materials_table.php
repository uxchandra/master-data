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
        Schema::create('item_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('supplier_materials')->cascadeOnDelete();
            $table->string('unique_no')->unique();
            $table->text('spec')->nullable();
            $table->string('shape')->nullable();
            $table->decimal('blank_thick', 10, 3)->nullable();
            $table->decimal('blank_width', 10, 3)->nullable();
            $table->decimal('blank_pitch', 10, 3)->nullable();
            $table->decimal('cut_thick', 10, 3)->nullable();
            $table->decimal('cut_width', 10, 3)->nullable();
            $table->decimal('cut_length', 10, 3)->nullable();
            $table->decimal('harga', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_materials');
    }
};
