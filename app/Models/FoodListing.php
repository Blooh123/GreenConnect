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
        'quantity_unit',
        'latitude',
        'longitude',
        'expiry_date',
        'status',
        'image_path',
        'special_instructions'
    ];

    protected $casts = [
        'expiry_date' => 'datetime',
        'quantity' => 'decimal:2'
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