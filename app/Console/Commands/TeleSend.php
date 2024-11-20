<?php

namespace App\Console\Commands;

use App\Models\Pengguna;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Laravel\Facades\Telegram;

class TeleSend extends Command
{
    protected $signature = 'tele-send';

    public function handle()
    {
        try {
            $token = env('TELEGRAM_BOT_TOKEN');

            $penggunas = Pengguna::whereNotNull('telegram')->get(['telegram','nama']);
            $events = DB::table('events')
                ->whereDate('tanggal',  Carbon::tomorrow())
                ->get();

                // Log::info($events);

            foreach ($events as $event) {
                foreach ($penggunas as $pengguna) {
                    $chatId = $pengguna->telegram;
                    $nama = $pengguna->nama;
                    $hari = Carbon::parse($event->tanggal)->locale('id')->isoFormat('dddd');
                    $tanggal = Carbon::parse($event->tanggal)->format('d-m-Y');

                    $message = "🔔 <b>REMINDER 🔔</b>\n\nSelamat pagi <i>{$nama}</i> ✨\n"
                         . "<b>{$hari}</b>, {$tanggal} adalah <b>{$event->judul}</b>.\n"
                         . "{$event->pesan}";


                    if (!empty($event->gambar)) {
                        $photoPath = public_path('images/poster/' . $event->gambar);
        
                            Telegram::sendPhoto([
                                'token' => $token,
                                'chat_id' => $chatId,
                                'photo' => InputFile::create($photoPath),
                                'caption' => $message,
                                'parse_mode' => 'HTML',
                            ]);
                    } else {
                        Telegram::sendMessage([
                            'token' => $token,
                            'chat_id' => $chatId,
                            'text' => $message,
                            'parse_mode' => 'HTML',
                        ]);
                    }
            } 
        }
            Log::info('Reminder sent successfully.');
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
        }
    }
}