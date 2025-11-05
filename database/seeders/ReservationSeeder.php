<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\Property;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        // Vérifie qu'il existe au moins une propriété
        if (Property::count() === 0) {
            $this->command->warn(' Aucune propriété trouvée. Exécute d\'abord le PropertySeeder.');
            return;
        }

        // Crée 10 réservations aléatoires
        foreach (range(1, 10) as $i) {
            $property = Property::inRandomOrder()->first();

            Reservation::create([
                'property_id'  => $property->id,
                'client_name'  => fake()->name(),
                'client_email' => fake()->unique()->safeEmail(),
                'client_phone' => fake()->phoneNumber(),
                'visit_date'   => Carbon::now()->addDays(rand(1, 30)),
                'message'      => fake()->sentence(),
                'status'       => fake()->randomElement(['pending', 'confirmed', 'cancelled', 'completed']),
            ]);
        }

        $this->command->info(' 10 réservations ont été ajoutées avec succès.');
    }
}
