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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: Nasi Goreng Spesial, Es Kopi Susu
            $table->text('description')->nullable(); // Bahan atau deskripsi singkat
            $table->unsignedInteger('price'); // Harga dalam Rupiah
            $table->string('image')->nullable(); // Foto makanan/minuman
            $table->string('category'); // Contoh: Makanan Berat, Cemilan, Kopi
            $table->string('status')->default('Tersedia'); // Status: Tersedia, Habis
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
