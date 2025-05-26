<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarbonFootprint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'transportation_emissions',
        'electricity_emissions',
        'food_emissions',
        'shopping_emissions',
        'total_emissions',
        'recorded_date',
        'notes'
    ];

    protected $casts = [
        'recorded_date' => 'date',
        'transportation_emissions' => 'decimal:2',
        'electricity_emissions' => 'decimal:2',
        'food_emissions' => 'decimal:2',
        'shopping_emissions' => 'decimal:2',
        'total_emissions' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 