<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Pengguna;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ReminderTelegram extends Command
{
    protected $signature = 'telegram:send-reminder';

    public function handle()
    {
        try {
            // ambil tanggal besok
            $tomorrow = Carbon::tomorrow();
            $token = env('TELEGRAM_BOT_TOKEN');
            $chatId = env('TELEGRAM_CHAT_ID');
            $events = DB::table('events')
                ->whereDate('tanggal', '=', $tomorrow)
                ->where('is_sent', false)
                ->get();

                Log::info($events);

            foreach ($events as $event) {
                // $message = "📢 Reminder: {$event->judul}\n\n"
                //          . "{$event->pesan}\n"
                //          . "Tanggal: {$event->tanggal}"; 

                $message = "Reminder: {$event->judul}";

                Http::post("https://api.telegram.org/bot{$token}/sendMessage", 
                [
                    'chat_id' => $chatId,
                    'text' => $message,
                    'parse_mode' => 'Markdown',
                ]);
            }
            Log::info('Reminder sent successfully');
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
        }
    }
}