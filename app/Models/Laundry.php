<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laundry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'contact',
        'services',
        'opening_hour',
        'closing_hour',
        'description',
        'owner_name',
        'owner_contact',
        'location',
        'latitude',
        'longitude',
        'photo',
        'additional_photos'
    ];
    
    protected $casts = [
        'services' => 'array',
        'opening_hour' => 'datetime',
        'closing_hour' => 'datetime',
        'additional_photos' => 'array'
    ];

    public function gallery()
    {
        return $this->hasMany(Gallery::class);
    }

    
}