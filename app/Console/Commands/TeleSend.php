<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TeleSend extends Command
{
    protected $signature = 'tele-send';

    public function handle() {
        $today = Carbon::today();
        
        $events = DB::table('events')
            ->whereDate('tanggal', '=', $today)
            ->where('is_sent', false)
            ->get();

        $users = DB::table('users')
            ->whereNotNull('telegram')
            ->get();

        foreach ($events as $event) {
            foreach ($users as $user) {
                $this->sendMessage($user->telegram, $event);
            }

            DB::table('events')
            ->where('id_event', $event->id_event)
            ->update(['is_sent' => true]);
        }

        $this->info('Reminder terkirim.');
    }

    protected function sendMessage($users, $event) {
        $token = env('TELEGRAM_BOT_TOKEN');
        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        $messageText = "{$event->judul}";

        Http::post($url, [
            'chatId' => $users,
            'text' => $messageText,
            'parse_mode' => 'Markdown'
        ]);
    }
}
