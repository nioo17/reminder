<?php

namespace App\Console\Commands;

use App\Models\Pengguna;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Laravel\Facades\Telegram;

class ReminderTelegram extends Command
{

    protected $signature = 'telegram:send-reminder';

    public function handle()
    {
        try {
            // Mengambil token bot Telegram dari file .env
            $token = env('TELEGRAM_BOT_TOKEN');

            // Mengambil semua pengguna yang memiliki ID Telegram
            $penggunas = Pengguna::whereNotNull('telegram')->pluck('telegram');

            // Mengambil data event yang memiliki tanggal besok
            $events = DB::table('events')
                ->whereDate('tanggal',  Carbon::tomorrow())
                ->get();

            foreach ($events as $event) {
                // Membuat pesan pengingat
                $message = "<b>📢 Reminder: {$event->judul}</b>\n\n"
                         . "{$event->pesan}\n"
                         . "Tanggal: " . Carbon::parse($event->tanggal)->format('d-m-Y'); 
            
                // Mengirimkan pesan dan gambar ke setiap pengguna yang terdaftar
                foreach ($penggunas as $pengguna) {
                    Telegram::sendPhoto([
                        'token' => $token,
                        'chat_id' => $pengguna,
                        'photo' => InputFile::create(public_path('images/poster/' . $event->gambar)),
                        'caption' => $message,
                        'parse_mode' => 'HTML', // Format pesan menggunakan HTML
                    ]);
                } 
            }

            // Log pesan jika pengingat berhasil dikirim
            Log::info('Reminder sent successfully.');
        } catch (\Throwable $th) {
            // Log pesan error jika terjadi kesalahan
            Log::info($th->getMessage());
        }
    }
}
