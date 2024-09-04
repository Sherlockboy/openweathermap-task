<?php

namespace App\Console;

use App\Console\Commands\FetchWeatherData;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        FetchWeatherData::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('weather:fetch')->hourly();
    }
}
