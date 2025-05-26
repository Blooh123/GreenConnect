<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'quantity',
        'unit',
        'expiry_date',
        'image',
        'special_instructions',
        'latitude',
        'longitude',
        'pickup_location',
        'status',
    ];

    protected $casts = [
        'quantity' => 'float',
        'expiry_date' => 'datetime',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired()
    {
        return $this->expiry_date->isPast();
    }
} 