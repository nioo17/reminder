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
            $token = env('TELEGRAM_BOT_TOKEN');

            $penggunas = Pengguna::whereNotNull('telegram')->pluck('telegram');
            $events = DB::table('events')
                ->whereDate('tanggal',  Carbon::tomorrow())
                ->get();

                Log::info($events);

            foreach ($events as $event) {
                $message = "<b>📢 Reminder: {$event->judul}</b>\n\n"
                         . "{$event->pesan}\n"
                         . "Tanggal: {$event->tanggal}"; 
            
                foreach ($penggunas as $pengguna) {
                    Telegram::sendPhoto([
                        'token' => $token,
                        'chat_id' => $pengguna,
                        'photo' => InputFile::create(public_path('images/poster/' . $event->gambar)),
                        'caption' => $message,
                        'parse_mode' => 'HTML',
                    ]);
            } 
        }
            Log::info('Reminder sent successfully.');
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
        }
    }
}