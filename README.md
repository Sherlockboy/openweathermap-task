# Weather API - Laravel Developer Task

We will use [**OpenWeatherMap API**](https://openweathermap.org/current) to get current weather data based on latitude/longitude.

- **API Link**: [https://openweathermap.org/current](https://openweathermap.org/current)
- **API Key**: `Get it from OpenWeatherMap website`
- **Technology: Laravel, MySQL, Redis**

---

# Task

- Pull the weather information of the cities of Uzbekistan and store it in the database every hour.
- Create APIs to retrieve weather data with API Documentation.
- Cover your APIs, functions and services with PHPUnit/Pest test-cases

# Rest API Endpoints

- `GET /api/cities`: Get the list of the stored cities
- `GET /api/weather/{city}`: Get the historical weather information for city
- `GET /api/weather/{city}/latest`: Get the latest weather information for city
- `GET /api/weather`: Get the list of the stored all weather data

# Data Models

### City Model

- City name
- Latitude
- Longitude

### Weather Model:

- City
- Time
- Weather name
- Latitude
- Longitude
- Temperature (in Celsius)
- MIN Temperature (in Celsius)
- MAX Temperature (in Celsius)
- Pressure
- Humidity

# Example Cities

| Name    | Latitude | Longitude |
|---------|----------|-----------|
| Tashkent | 41.2995 | 69.2401 |
| Samarkand | 39.6542 | 66.9597 |
| Bukhara | 39.7745 | 64.4286 |
| Khiva | 41.3786 | 60.3560 |
| Nukus | 42.4611 | 59.6164 |
| Andijan | 40.7821 | 72.3442 |
| Namangan | 40.9983 | 71.6726 |
| Fergana | 40.3864 | 71.7864 |
| Termiz | 37.2241 | 67.2783 |
| Kokand | 40.5306 | 70.9428 |

# Submission:

Fork this repository and make your changes in that forked repo. Once you finish the task, create Pull Request from the forked repo to the main repo. Tag following people as reviewer in your PR and notify the recruiter:
- @Sherlockboy

Also, update the readme with the instructions of how to run the project and get the data locally.


# Instructions: 

1. Clone the repository:

```
git clone <repository-url>
cd <project-directory>
```

2. Install dependencies:

```
composer install
```

3. Copy .env.example to .env and configure your database settings as well as in config/database and OpenWeatherMap API key as OPENWEATHERMAP_API_KEY:

```
cp .env.example .env
```

4. Generate application key:

```
php artisan key:generate
```

5. Run migrations:

```
php artisan migrate
```

6. Seed the database with Uzbekistan cities:

```
php artisan db:seed --class=CitiesSeeder
```

7. Set up service or cron job to run the following command hourly, I used systemd services to run hourly, but you can use Laravel Scheduler which is configured in Console/Kernel.php with crontab:

```
php artisan weather:fetch
```

8. Be sure that your laravel queue is processed

```
php artisan queue:work
```

9. Set up your testing environment by creating env.testing, where APP_ENV=testing DB_CONNECTION=sqlite DB_DATABASE=:memory: and put your APP_KEY from .env file

10. Clear config cache by

```
php artisan config:clear
```

11. Repeat steps 5 and 6 for testing environment with command

```
php artisan migrate --env=testing
php artisan db:seed --class=CitiesSeeder --env=testing
```

12. Run Unit Tests by 

```
php artisan test --env=testing
```

13. You can check API Swagger Documentation at http://yourserver/api/documentation
