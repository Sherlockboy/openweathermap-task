<?php

namespace App\Repositories;

use App\Models\City;
use App\Models\Weather;
use App\Repositories\Interfaces\WeatherRepositoryInterface;

/**
 * Class WeatherRepository
 *
 * This class implements the WeatherRepositoryInterface and provides methods
 * to interact with the Weather model, specifically focusing on weather data
 * related to cities.
 */
class WeatherRepository implements WeatherRepositoryInterface
{
    /**
     * Get the weather records for a specific city, ordered by time in descending order.
     *
     * @param \App\Models\City $city
     * @return \Illuminate\Database\Eloquent\Collection|\App\Models\Weather[]
     */
    public function getForCity(City $city)
    {
        return $city->weather()->orderBy('time', 'desc')->get();
    }

    /**
     * Get the latest weather record for a specific city.
     *
     * @param \App\Models\City $city
     * @return \App\Models\Weather|null
     */
    public function getLatestForCity(City $city)
    {
        return $city->weather()->latest('time')->first();
    }

    /**
     * Get all weather records, including their associated cities, ordered by time in descending order.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\App\Models\Weather[]
     */
    public function all()
    {
        return Weather::with('city')->orderBy('time', 'desc')->get();
    }
}

