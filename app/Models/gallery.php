<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'laundry_id',
        'photo',
        'caption'
    ];

    public function laundry()
    {
        return $this->belongsTo(Laundry::class);
    }

    
}