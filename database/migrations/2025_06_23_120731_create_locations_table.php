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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('address'); 
            $table->string('city'); 
            $table->text('description'); 
            $table->string('phone_number')->nullable(); 
            $table->string('featured_image')->nullable(); 
            $table->decimal('latitude', 10, 7)->nullable(); 
            $table->decimal('longitude', 11, 7)->nullable(); 
            $table->string('status')->default('open'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
