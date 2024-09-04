<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            ['name' => 'Tashkent', 'latitude' => 41.2995, 'longitude' => 69.2401],
            ['name' => 'Samarkand', 'latitude' => 39.6542, 'longitude' => 66.9597],
            ['name' => 'Bukhara', 'latitude' => 39.7745, 'longitude' => 64.4286],
            ['name' => 'Khiva', 'latitude' => 41.3786, 'longitude' => 60.3560],
            ['name' => 'Nukus', 'latitude' => 42.4611, 'longitude' => 59.6164],
            ['name' => 'Andijan', 'latitude' => 40.7821, 'longitude' => 72.3442],
            ['name' => 'Namangan', 'latitude' => 40.9983, 'longitude' => 71.6726],
            ['name' => 'Fergana', 'latitude' => 40.3864, 'longitude' => 71.7864],
            ['name' => 'Termiz', 'latitude' => 37.2241, 'longitude' => 67.2783],
            ['name' => 'Kokand', 'latitude' => 40.5306, 'longitude' => 70.9428],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}

