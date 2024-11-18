<?php

use App\Models\Pengguna;
use App\Mail\ReminderMail;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Application;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->call(function () {
            $currentDate = Carbon::now()->startOfDay();
            $targetDate = [
                $currentDate->copy()->addDays(2),
                $currentDate->copy()->addDays(1),
                $currentDate
            ];

            $events = Event::whereIn('tanggal', $targetDate)->get();
            foreach ($events as $event){

                $penggunas = Pengguna::all();
                foreach ($penggunas as $pengguna) {
                    $messageContent = "Halo {$pengguna->nama}, ini adalah {$event->judul}.";
                    $pesanevent = "{$event->pesan}";
                    $gambarevent = asset('images/poster/' . $event->gambar);

                    Log::info("Scheduler running at: " . now());

                    Mail::to($pengguna->email)->send(new ReminderMail($messageContent, $pesanevent, $gambarevent));
                }
            }
        })->dailyAt('16:41');
    })
    ->create();
