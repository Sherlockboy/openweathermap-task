<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Weather extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'city_id', 'time', 'weather_name', 'latitude', 'longitude', 'temperature',
        'min_temperature', 'max_temperature', 'pressure', 'humidity'
    ];


    /**
     * Get the weather records for the city.
     *
     * @return HasMany
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}

