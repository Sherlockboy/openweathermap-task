<?php
namespace App\Repositories\Interfaces;

use App\Models\City;

/**
 * Interface WeatherRepositoryInterface
 *
 * This interface defines the contract for a repository that handles data access
 * operations related to weather, particularly in the context of cities.
 */
interface WeatherRepositoryInterface
{
     /**
     * Get the weather records for a specific city, ordered by time in descending order.
     *
     * @param \App\Models\City $city
     * @return \Illuminate\Database\Eloquent\Collection|\App\Models\Weather[]
     */
    public function getForCity(City $city);

     /**
     * Get the latest weather record for a specific city.
     *
     * @param \App\Models\City $city
     * @return \App\Models\Weather|null
     */
    public function getLatestForCity(City $city);

    /**
     * Retrieve all weather records, including their associated cities, ordered by time in descending order.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\App\Models\Weather[]
     */
    public function all();
}

