<?php

use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Route;

Route::get('/cities', [WeatherController::class, 'cities']);
Route::get('/weather/{city}', [WeatherController::class, 'cityWeather']);
Route::get('/weather/{city}/latest', [WeatherController::class, 'latestCityWeather']);
Route::get('/weather', [WeatherController::class, 'allWeather']);
