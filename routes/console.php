<?php

use App\Console\Commands\SendReminder;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;

// Schedule::command(SendReminder::class)->everyMinute();