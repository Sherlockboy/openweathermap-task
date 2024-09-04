<?php
namespace App\Repositories;

use App\Models\City;
use App\Repositories\Interfaces\CityRepositoryInterface;

/**
 * Class CityRepository
 *
 * This class implements the CityRepositoryInterface and provides methods
 * to interact with the City model, encapsulating the data access logic
 * for the City entity.
 */
class CityRepository implements CityRepositoryInterface
{
    /**
     * Retrieve all cities from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return City::all();
    }

    /**
     * Find a city by its ID.
     * Throws an exception if the city is not found.
     *
     * @param int $id
     * @return \App\Models\City
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function find(int $id)
    {
        return City::findOrFail($id);
    }

    /**
     * Find a city by its name.
     * Throws an exception if the city is not found.
     *
     * @param string $name
     * @return \App\Models\City
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findByName(string $name)
    {
        return City::where('name', $name)->firstOrFail();
    }
}

