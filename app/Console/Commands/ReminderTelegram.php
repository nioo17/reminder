<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Pengguna;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class ReminderTelegram extends Command
{
    protected $signature = 'telegram:send-reminder';

    public function handle()
    {
        $today = Carbon::today();
        $token = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');
        $events = DB::table('events')
            ->whereDate('tanggal', '=', $today)
            ->where('is_sent', false)
            ->get();

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
    }
}