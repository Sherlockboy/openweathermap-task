<?php

namespace App\Repositories\Interfaces;


/**
 * Interface CityRepositoryInterface
 *
 * This interface defines the contract for a repository that handles data access
 * operations related to cities.
 */
interface CityRepositoryInterface
{

    /**
     * Retrieve all cities.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\App\Models\City[]
     */
    public function all();

     /**
     * Find a city by its ID.
     *
     * @param int $id
     * @return \App\Models\City
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function find(int $id);

     /**
     * Find a city by its name.
     *
     * @param string $id
     * @return \App\Models\City
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findByName(string $name);
}

