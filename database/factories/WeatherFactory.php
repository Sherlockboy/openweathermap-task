<?php

namespace Database\Factories;
use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Weather>
 */
class WeatherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'city_id' => City::factory(),
            'time' => now(),
            'weather_name' => $this->faker->word,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'temperature' => $this->faker->numberBetween(0, 40),
            'min_temperature' => $this->faker->numberBetween(-10, 20),
            'max_temperature' => $this->faker->numberBetween(20, 50),
            'pressure' => $this->faker->numberBetween(980, 1050),
            'humidity' => $this->faker->numberBetween(20, 100),
        ];
    }
}
