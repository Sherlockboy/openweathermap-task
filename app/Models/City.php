<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'latitude', 'longitude'];

    /**
     * Get the weather records for the city.
     *
     * @return HasMany
     */
    public function weather(): HasMany
    {
        return $this->hasMany(Weather::class);
    }
}

