<?php

namespace App\Jobs;

use App\Models\City;
use App\Services\Interfaces\WeatherServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchCityWeather implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $city;

    public function __construct(City $city)
    {
        $this->city = $city;
    }

    public function handle(WeatherServiceInterface $weatherService)
    {
        $weather = $weatherService->fetchWeatherData($this->city);

        if ($weather) {
            info("Weather data fetched for {$this->city->name}");
        } else {
            error_log("Failed to fetch weather data for {$this->city->name}");
        }
    }
}

