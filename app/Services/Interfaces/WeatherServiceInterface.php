<?php

namespace App\Services\Interfaces;

use App\Models\City;
use App\Models\Weather;


/**
 * Interface for weather-related services.
 */
interface WeatherServiceInterface
{
    /**
     * Fetch weather data for a given city.
     *
     * @param City $city The city to fetch weather data for.
     * @return Weather|null The fetched weather data, or null if the fetch failed.
     */
    public function fetchWeatherData(City $city): ?Weather;

    /**
     * Get the latest weather data for a given city.
     *
     * @param City $city The city to get the latest weather for.
     * @return Weather|null The latest weather data, or null if not found.
     */
    public function getLatestWeather(City $city): ?Weather;
}

