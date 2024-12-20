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

            $events = Event::whereIn('tanggal', $targetDate)->get();
            foreach ($events as $event){
                // Mengatur format tanggal event
                $hari = Carbon::parse($event->tanggal)->locale('id')->isoFormat('dddd');
                $formatdate = Carbon::parse($event->tanggal)->format('d-m-Y');

                if ($event->kategori == 'Jadwal Atasan') {
                    // Memanggil pengguna atasan
                    $atasans = Pengguna::where('jabatan', 'Atasan')->get();
                    foreach ($atasans as $atasan) {
                        // Menyiapkan konten email yang akan dikirimkan
                        $messageContent = "Yang terhormat ibu {$atasan->nama}, pada {$hari}, {$formatdate} ada event {$event->judul} yang akan datang.";
                        $pesanevent = "{$event->pesan}";
                        $gambarevent = asset('images/poster/' . $event->gambar);

                        Log::info("Mengirim email ke atasan: {$atasan->email}");
                        // Mengirim email menggunakan mailable ReminderMail
                        Mail::to($atasan->email)->send(new ReminderMail($messageContent, $pesanevent, $gambarevent));
                    }
                } else {
                    $penggunas = Pengguna::all();
                    foreach ($penggunas as $pengguna) {
                        if ($pengguna->jabatan == 'Karyawan' && $event->kategori == 'Jadwal Atasan') {
                            continue;
                        }
                        // Menyiapkan konten email yang akan dikirimkan
                        $messageContent = "Halo {$pengguna->nama}, pada {$hari}, {$formatdate} ada event {$event->judul} yang akan datang.";
                        $pesanevent = "{$event->pesan}";
                        $gambarevent = asset('images/poster/' . $event->gambar);
    
                        Log::info("Mengirim email ke pengguna: {$pengguna->email}");
    
                        // Mengirim email menggunakan mailable ReminderMail
                        Mail::to($pengguna->email)->send(new ReminderMail($messageContent, $pesanevent, $gambarevent));
                    }
                }
            }
        })->dailyAt('15:04');

        // Menjadwalkan tugas lain
        $schedule->command('tele-send')->dailyAt('15:04');
    })
    ->create();
