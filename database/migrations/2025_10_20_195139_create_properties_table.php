<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('purpose', ['sell', 'rent']);
            $table->string('category');
            $table->decimal('price', 15, 2);
            $table->string('currency', 10)->default('MAD');
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('area_m2')->nullable();
            $table->string('location')->nullable();
            $table->enum('status', ['published', 'draft'])->default('draft');
            $table->string('reference_code')->unique();
            $table->json('images')->nullable();
            $table->text('description')->nullable();
            $table->integer('kitchen')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
