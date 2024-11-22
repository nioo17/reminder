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
            // Mengambil token bot Telegram dari file .env
            $token = env('TELEGRAM_BOT_TOKEN');

            // Mengambil data pengguna yang memiliki ID Telegram, termasuk nama mereka
            $penggunas = Pengguna::whereNotNull('telegram')->get(['telegram', 'nama']);

            
            // Mengambil data event yang memiliki tanggal besok dan lusa
            $events = DB::table('events')
            ->whereBetween('tanggal', [
                Carbon::tomorrow()->startOfDay(),
                Carbon::tomorrow()->addDay(1),
                Carbon::now()->startOfDay()
            ])
            ->get();


            // $events = DB::table('events')
            //     ->whereDate('tanggal', Carbon::tomorrow())
            //     ->get();

            // Iterasi melalui setiap pengguna yang akan menerima pengingat
            foreach ($penggunas as $pengguna) {
                // Mendapatkan data ID Telegram dan nama pengguna
                $chatId = $pengguna->telegram;
                $nama = $pengguna->nama;

                // Iterasi melalui setiap event yang ditemukan
                foreach ($events as $event) {
                    // Mengirim pesan kategori tertentu
                    if ($event->kategori === 'Jadwal Atasan') {
                        if ((string) $chatId !== '6969215754') {
                            continue; // Skip pengguna lain jika ID tidak cocok
                        }
                    }

                    // Mengatur format hari dan tanggal dalam bahasa Indonesia
                    $hari = Carbon::parse($event->tanggal)->locale('id')->isoFormat('dddd');
                    $tanggal = Carbon::parse($event->tanggal)->format('d-m-Y');

                    // Membuat pesan pengingat dengan personalisasi nama dan informasi event
                    $message = "🔔 <b>REMINDER 🔔</b>\n\nSelamat pagi <i>{$nama}</i> ✨\n"
                             . "<b>{$hari}</b>, {$tanggal} adalah <b>{$event->judul}</b>.\n"
                             . "{$event->pesan}";

                    // Memeriksa apakah ada gambar yang terkait dengan event
                    if (!empty($event->gambar)) {
                        // Mendapatkan path gambar dari folder public
                        $photoPath = public_path('images/poster/' . $event->gambar);
                        
                        // Mengirimkan gambar dengan pesan
                        Telegram::sendPhoto([
                            'token' => $token, 
                            'chat_id' => $chatId, 
                            'photo' => InputFile::create($photoPath),
                            'caption' => $message,
                            'parse_mode' => 'HTML',
                        ]);
                    } else {
                        // Mengirimkan pesan teks saja jika tidak ada gambar
                        Telegram::sendMessage([
                            'token' => $token, 
                            'chat_id' => $chatId, 
                            'text' => $message,
                            'parse_mode' => 'HTML',
                        ]);
                    }
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
