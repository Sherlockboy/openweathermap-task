<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\CityRepositoryInterface;
use App\Repositories\Interfaces\WeatherRepositoryInterface;
use App\Services\Interfaces\WeatherServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;


/**
 * @OA\Info(
 *     title="Weather API",
 *     version="1.0.0",
 *     description="API for retrieving weather data for cities in Uzbekistan",
 *     @OA\Contact(
 *         name="Aziz Riskulov",
 *         email="vinceere@gmail.com"
 *     ),
 * )
 *
 * @OA\Tag(
 *   name="Cities",
 *   description="Operations related to cities"
 * )
 *
 * @OA\Tag(
 *   name="Weather",
 *   description="Operations related to weather data"
 * )
 */

class WeatherController extends Controller
{
    public function __construct(
        private WeatherServiceInterface $weatherService,
        private CityRepositoryInterface $cityRepository,
        private WeatherRepositoryInterface $weatherRepository
    ) {}

    /**
     * @OA\Get(
     *     path="/api/cities",
     *     summary="Get all cities",
     *     tags={"Cities"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of cities",
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(ref="#/definitions/City")
     *         )
     *     ),
     *     @OA\Response(response=500, description="Failed to retrieve cities")
     * )
     */
    public function cities(): JsonResponse
    {
        try {
            $cities = $this->cityRepository->all();
            return response()->json($cities);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve cities'], 500);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/weather/{cityName}",
     *     summary="Get weather data for a specific city",
     *     tags={"Weather"},
     *     @OA\Parameter(
     *         name="cityName",
     *         in="path",
     *         required=true,
     *         description="The name of the city",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Weather data for the specified city",
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(ref="#/definitions/Weather")
     *         )
     *     ),
     *     @OA\Response(response=404, description="City not found"),
     *     @OA\Response(response=500, description="Failed to retrieve weather data")
     * )
     */
    public function cityWeather(string $cityName): JsonResponse
    {
        try {
            $city = $this->cityRepository->findByName($cityName);
            $weather = $this->weatherRepository->getForCity($city);
            return response()->json($weather);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'City not found'], 404);

        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve weather data'], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/weather/{cityName}/latest",
     *     summary="Get latest weather data for a specific city",
     *     tags={"Weather"},
     *     @OA\Parameter(
     *         name="cityName",
     *         in="path",
     *         required=true,
     *         description="The name of the city",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Latest weather data for the specified city",
     *         @OA\Schema(ref="#/definitions/Weather")
     *     ),
     *     @OA\Response(response=404, description="City not found or no weather data available"),
     *     @OA\Response(response=500, description="Failed to retrieve latest weather data")
     * )
     */
    public function latestCityWeather(string $cityName): JsonResponse
    {
        try {
            $city = $this->cityRepository->findByName($cityName);
            \Log::info("Retrieving latest weather for city: " . $city->name);

            $latestWeather = $this->weatherService->getLatestWeather($city);
            if ($latestWeather === null) {
                return response()->json(['error' => 'No weather data available'], 404);
            }
            return response()->json($latestWeather);
        } catch (ModelNotFoundException $e) {
            \Log::error("City not found: " . $cityName);
            return response()->json(['error' => 'City not found'], 404);
        } catch (Exception $e) {
            \Log::error("Error retrieving latest weather for city " . $cityName . ": " . $e->getMessage());
            return response()->json(['error' => 'Failed to retrieve latest weather data'], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/weather",
     *     summary="Get all weather data",
     *     tags={"Weather"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of all weather data",
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(ref="#/definitions/Weather")
     *         )
     *     ),
     *     @OA\Response(response=500, description="Failed to retrieve all weather data")
     * )
     */
    public function allWeather(): JsonResponse
    {
        try {
            $allWeather = $this->weatherRepository->all();
            return response()->json($allWeather);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve all weather data'], 500);
        }
    }
}
