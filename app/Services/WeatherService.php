<?php

namespace App\Services;

use App\Models\City;
use App\Models\Weather;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Services\Interfaces\WeatherServiceInterface;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\RequestException;
use Exception;

class WeatherService implements WeatherServiceInterface
{
    private $apiKey;
    private $apiUrl = 'https://api.openweathermap.org/data/2.5/weather';

    public function __construct()
    {
        $this->apiKey = env('OPENWEATHERMAP_API_KEY');
    }

    /**
     * @inheritDoc
     */
    public function fetchWeatherData(City $city): ?Weather
    {
        try {
            $response = Http::get($this->apiUrl, [
                'lat' => $city->latitude,
                'lon' => $city->longitude,
                'appid' => $this->apiKey,
                'units' => 'metric',
            ]);
            Log::info('Fetching weather data from: ' . $this->apiKey );

            $response->throw();

            if ($response->successful()) {
                $data = $response->json();
                $weather = Weather::create([
                    'city_id' => $city->id,
                    'time' => now(),
                    'weather_name' => $data['weather'][0]['main'],
                    'latitude' => $city->latitude,
                    'longitude' => $city->longitude,
                    'temperature' => $data['main']['temp'],
                    'min_temperature' => $data['main']['temp_min'],
                    'max_temperature' => $data['main']['temp_max'],
                    'pressure' => $data['main']['pressure'],
                    'humidity' => $data['main']['humidity'],
                ]);

                $this->cacheLatestWeather($city, $weather);


                return $weather;
            }

        } catch (RequestException $e) {
             Log::error("API request failed for city {$city->name}: " . $e->getMessage());
             return null;
        } catch (Exception $e) {
             Log::error("Error fetching weather data for city {$city->name}: " . $e->getMessage());
             return null;
        }

            return null;
    }

    public function getLatestWeather(City $city): ?Weather
    {
        try {
            $cacheKey = "weather:{$city->id}:latest";

            // Try to get the data from Redis cache
            $cachedData = Redis::get($cacheKey);

            if ($cachedData) {
                return unserialize($cachedData);
            }

            // If not in cache, fetch from database and cache it
            $latestWeather = $city->weather()->latest('time')->first();

            if ($latestWeather) {
                $this->cacheLatestWeather($city, $latestWeather);
            }

            return $latestWeather;
        } catch (Exception $e) {
            Log::error("Error retrieving latest weather for city {$city->name}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Cache the latest weather data for a city in Redis.
     *
     * @param City $city
     * @param Weather $weather
     */
    private function cacheLatestWeather(City $city, Weather $weather): void
    {
        $cacheKey = "weather:{$city->id}:latest";
        Redis::setex($cacheKey, 3600, serialize($weather)); // Cache for 1 hour
    }
}

