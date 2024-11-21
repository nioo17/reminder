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
        // Menjadwalkan tugas yang akan dijalankan secara periodik
        $schedule->call(function () {
            // Mendapatkan tanggal saat ini dan dua tanggal ke depan
            $currentDate = Carbon::now()->startOfDay(); // Memulai hari saat ini (jam 00:00)
            $targetDate = [
                $currentDate->copy()->addDays(2)->format('y-m-d'),
                $currentDate->copy()->addDays(1)->format('y-m-d'),
                $currentDate->format('y-m-d')
            ];
            $penggunas = Pengguna::all();

            $events = Event::whereIn('tanggal', $targetDate)->get();
            foreach ($events as $event){
                foreach ($penggunas as $pengguna) {
                    // Mengatur format tanggal event
                    $formatdate = Carbon::parse($event->tanggal)->format('d-m-Y');

                    // Menyiapkan konten email yang akan dikirimkan
                    $messageContent = "Halo {$pengguna->nama}, pada tanggal {$formatdate} ada event {$event->judul} yang akan datang.";
                    $pesanevent = "{$event->pesan}";
                    $gambarevent = asset('images/poster/' . $event->gambar);

                    Log::info("Scheduler running at: " . now());

                    // Mengirim email menggunakan mailable ReminderMail
                    Mail::to($pengguna->email)->send(new ReminderMail($messageContent, $pesanevent, $gambarevent));
                }
            }
        })->dailyAt('15:46');

        // Menjadwalkan tugas lain
        $schedule->command('tele-send')->dailyAt('15:46');
    })
    ->create();
