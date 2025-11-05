<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Riads' => ['prefix' => 'riad', 'bedrooms' => [3,6], 'bathrooms' => [1,4], 'area' => [200,400], 'kitchen' => 1],
            'Appartements' => ['prefix' => 'app', 'bedrooms' => [1,4], 'bathrooms' => [1,3], 'area' => [50,150], 'kitchen' => 1],
            'Villa' => ['prefix' => 'villa', 'bedrooms' => [3,6], 'bathrooms' => [2,4], 'area' => [200,500], 'kitchen' => 1],
            'Bureau' => ['prefix' => 'bureau', 'bedrooms' => null, 'bathrooms' => null, 'area' => [50,300], 'kitchen' => null],
            'Terrain' => ['prefix' => 'tr', 'bedrooms' => null, 'bathrooms' => null, 'area' => [100,1000], 'kitchen' => null],
            'Medical' => ['prefix' => 'cb', 'bedrooms' => null, 'bathrooms' => null, 'area' => [80,400], 'kitchen' => null],
        ];

        $purposes = ['sell', 'rent'];
        $cities = ['Marrakech', 'Casablanca', 'Rabat', 'Fès', 'Agadir', 'Tanger'];
        $properties = [];

        foreach ($categories as $name => $data) {
            foreach ($purposes as $purpose) {
                for ($i = 1; $i <= 20; $i++) {
                    $bedrooms = is_array($data['bedrooms']) ? rand($data['bedrooms'][0], $data['bedrooms'][1]) : null;
                    $bathrooms = is_array($data['bathrooms']) ? rand($data['bathrooms'][0], $data['bathrooms'][1]) : null;
                    $area = rand($data['area'][0], $data['area'][1]);
                    $price = $this->generatePrice($name, $purpose);
                    $city = $cities[array_rand($cities)];

                    // Générer les 4 images et les mélanger aléatoirement
                    $images = [];
                    for ($imgNum = 1; $imgNum <= 4; $imgNum++) {
                        $images[] = "/properties/{$data['prefix']}{$imgNum}.jpg";
                    }
                    shuffle($images); // mélange aléatoire

                    $properties[] = [
                        'title' => "$name $purpose #$i",
                        'purpose' => $purpose,
                        'category' => strtolower($name),
                        'price' => $price,
                        'currency' => 'MAD',
                        'bedrooms' => $bedrooms,
                        'bathrooms' => $bathrooms,
                        'area_m2' => $area,
                        'location' => $city,
                        'status' => 'published',
                        'reference_code' => strtoupper($data['prefix']) . '-' . strtoupper(substr($purpose,0,1)) . '-' . str_pad($i,3,'0',STR_PAD_LEFT),
                        'images' => $images,
                        'description' => "Belle propriété $name à $purpose au Maroc, située à $city.",
                        'kitchen' => $data['kitchen'],
                    ];
                }
            }
        }

        // Mélanger toutes les propriétés pour un ordre complètement aléatoire
        shuffle($properties);

        foreach ($properties as $prop) {
            Property::create($prop);
        }
    }

    private function generatePrice($category, $purpose)
    {
        switch ($category) {
            case 'Riads': return 1500000;
            case 'Appartements': return $purpose === 'sell' ? rand(500000,1500000) : rand(5000,15000);
            case 'Villa': return $purpose === 'sell' ? rand(2000000,5000000) : rand(15000,40000);
            case 'Bureau': return $purpose === 'sell' ? rand(800000,3000000) : rand(7000,25000);
            case 'Terrain': return $purpose === 'sell' ? rand(300000,2000000) : rand(2000,15000);
            case 'Medical': return $purpose === 'sell' ? rand(600000,2500000) : rand(5000,20000);
            default: return 0;
        }
    }
}
