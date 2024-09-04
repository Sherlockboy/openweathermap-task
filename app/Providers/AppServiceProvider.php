<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Interfaces\WeatherServiceInterface;
use App\Services\WeatherService;
use App\Repositories\Interfaces\CityRepositoryInterface;
use App\Repositories\CityRepository;
use App\Repositories\Interfaces\WeatherRepositoryInterface;
use App\Repositories\WeatherRepository;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(WeatherServiceInterface::class, WeatherService::class);
        $this->app->bind(CityRepositoryInterface::class, CityRepository::class);
        $this->app->bind(WeatherRepositoryInterface::class, WeatherRepository::class);
    }
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
