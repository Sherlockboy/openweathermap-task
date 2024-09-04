<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Weather;
use App\Services\WeatherService;
use Database\Seeders\CitiesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Mockery;

class WeatherApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Log::spy();
    }

    public function test_get_cities()
    {
        City::factory()->count(3)->create();
        $response = $this->get('/api/cities');

        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJsonStructure([
                '*' => ['id', 'name', 'latitude', 'longitude']
            ]);
    }

    public function test_get_weather_historical()
    {
        $city = City::factory()->create(['name' => 'Samarkand']);
        Weather::factory()->count(5)->create(['city_id' => $city->id]);

        $response = $this->get("/api/weather/Samarkand");

        $response->assertStatus(200)
                 ->assertJsonCount(5)
                 ->assertJsonStructure([
                     '*' => ['id', 'city_id', 'weather_name', 'temperature', 'time']
                 ]);
    }

    public function test_get_latest_weather()
    {
        $city = City::factory()->create(['name' => 'Bukhara']);
        $oldWeather = Weather::factory()->create([
            'city_id' => $city->id,
            'weather_name' => 'Sunny',
            'time' => now()->subHours(2)
        ]);
        $latestWeather = Weather::factory()->create([
            'city_id' => $city->id,
            'weather_name' => 'Rainy',
            'time' => now()->subHour()
        ]);



        $response = $this->get("/api/weather/Bukhara/latest");
        \Log::info($response->getContent());

        $response->assertStatus(200)
                 ->assertJsonFragment(['weather_name' => 'Rainy'])
                 ->assertJsonMissing(['weather_name' => 'Sunny']);
    }

    public function test_get_all_weather_data()
    {
        $cities = City::factory()->count(3)->create();
        foreach ($cities as $city) {
            Weather::factory()->count(2)->create(['city_id' => $city->id]);
        }

        $response = $this->get('/api/weather');

        $response->assertStatus(200)
                 ->assertJsonCount(6);
    }

    public function test_get_weather_for_nonexistent_city()
    {
        $response = $this->get("/api/weather/NonexistentCity/latest");

        $response->assertStatus(404)
                 ->assertJson(['error' => 'City not found']);
    }


    public function test_weather_service_fetches_and_stores_data()
    {
        Http::fake([
            'api.openweathermap.org/*' => Http::response([
                'weather' => [['main' => 'Rainy']],
                'main' => ['temp' => 15, 'temp_min' => 14, 'temp_max' => 16, 'pressure' => 1010, 'humidity' => 80],
            ], 200),
        ]);

        $city = City::factory()->create(['name' => 'Tashkent']);
        $weatherService = app(WeatherService::class);

        $weather = $weatherService->fetchWeatherData($city);

        $this->assertNotNull($weather);
        $this->assertEquals('Rainy', $weather->weather_name);
        $this->assertEquals(15, $weather->temperature);
    }

    public function test_weather_service_handles_api_error()
    {
        Http::fake([
            'api.openweathermap.org/*' => Http::response(null, 500),
        ]);

        $city = City::factory()->create(['name' => 'Tashkent']);
        $weatherService = app(WeatherService::class);

        $weather = $weatherService->fetchWeatherData($city);

        $this->assertNull($weather);
        Log::assertLogged('error', function ($message) {
            return str_contains($message, 'Error fetching weather data for city Tashkent');
        });
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}

