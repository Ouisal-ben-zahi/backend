<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'purpose',
        'category',
        'price',
        'currency',
        'bedrooms',
        'bathrooms',
        'area_m2',
        'location',
        'status',
        'reference_code',
        'images',
        'description',
        'kitchen',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    /**
     * Relation : une propriété peut avoir plusieurs réservations.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'property_id');
    }
}
