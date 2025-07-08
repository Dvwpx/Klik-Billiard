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
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul Promo, cth: "Happy Hour Seru!"
            $table->text('description'); // Deskripsi singkat promo
            $table->string('banner_image'); // Path ke gambar banner
            $table->string('link_url')->nullable(); // URL tujuan jika banner di-klik
            $table->string('status')->default('inactive'); // Status: active, inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
