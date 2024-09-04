<?php

namespace App\Console\Commands;

use App\Repositories\Interfaces\CityRepositoryInterface;
use App\Jobs\FetchCityWeather;
use Illuminate\Console\Command;

class FetchWeatherData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch weather data for all cities';

    /**
     * Execute the console command.
     *
     * @param WeatherServiceInterface $weatherService
     * @param CityRepositoryInterface $cityRepository
     * @return int
     */
    public function handle(CityRepositoryInterface $cityRepository): int
    {
        $cities = $cityRepository->all();

        foreach ($cities as $city) {
            FetchCityWeather::dispatch($city);
            $this->info("Weather fetch job dispatched for {$city->name}");
        }

        return 0;
    }
}
