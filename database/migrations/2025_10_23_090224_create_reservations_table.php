<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            
            //  Relation vers la propriété
            $table->foreignId('property_id')
                ->constrained('properties')
                ->onDelete('cascade');
            
            //  Informations du client
            $table->string('client_name');
            $table->string('client_email');
            $table->string('client_phone');

            //  Informations de réservation
            $table->dateTime('visit_date');
            $table->text('message')->nullable();
            
            //  Statut de réservation
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');

            $table->timestamps();

            //  Index pour les performances
            $table->index('property_id');
            $table->index('status');
            $table->index('visit_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
