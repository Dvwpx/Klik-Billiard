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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama lengkap pemain
            $table->string('slug')->unique();
            $table->string('nickname')->nullable(); // Julukan atau nama panggilan
            $table->string('profile_image')->nullable(); // Foto profil pemain
            $table->text('bio')->nullable(); // Biografi singkat, gaya bermain, dll.
            $table->text('achievements')->nullable(); // Daftar prestasi/gelar
            $table->string('status')->default('active'); // Status: active, inactive, retired
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
