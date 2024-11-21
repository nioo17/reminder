<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class EventController extends Controller
{
    // Fungsi untuk menampilkan semua data event pada halaman 'dataevent'
    public function index()
    {
        $events = Event::all();
        return view('event.dataevent', compact('events'));
    }

    // Menampilkan event dalam kalender
    public function getCalendarEvents()
    {
        $events = Event::all();
        
        $calendarEvents = [];
        
        foreach($events as $event) {
            $backgroundColor = '';
            $textColor = 'white';
            
            // Sesuaikan warna berdasarkan kategori
            if($event->kategori == 'Hari Raya Keagamaan') {
                $backgroundColor = 'yellow';
                $textColor = 'black';
            } else if($event->kategori == 'Hari Nasional') {
                $backgroundColor = 'red';
            } else if($event->kategori == 'Hari Kerja') {
                $backgroundColor = 'blue';
            } else if($event->kategori == 'Jadwal Atasan') {
                $backgroundColor = 'green';
            }
            
            // menampilkan pop up dalam kalender
            $calendarEvents[] = [
                'title' => $event->judul,
                'start' => $event->tanggal,
                'description' => $event->pesan,
                'backgroundColor' => $backgroundColor,
                'borderColor' => $backgroundColor,
                'textColor' => $textColor,
                'imageUrl' => $event->gambar ? asset('images/poster/' . $event->gambar) : asset('images/no_image.png')
            ];
        }
        
        // Mengembalikan data kalender dalam format JSON
        return response()->json($calendarEvents);
    }

    // Fungsi untuk menyimpan data event baru ke dalam database
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'judul' => 'required|string',
                'tanggal' => 'required|date',
                'pesan' => 'required|string|max:255',
                'kategori' => 'required|in:Hari Raya Keagamaan,Hari Nasional,Hari Kerja,Jadwal Atasan',
                'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:255' // Validasi gambar manual
            ]);

            // Jika ada file gambar, proses dan simpan ke folder 'images/poster'
            if ($request->hasFile('gambar')) {
                $fileName = time() . $request->file('gambar')->getClientOriginalName();
                $request->file('gambar')->move(public_path('images/poster'), $fileName);
                $validatedData['gambar'] = $fileName;
            }
    
            Event::create($validatedData); // Menyimpan data event ke database
    
            return redirect()->route('event.index')->with('success', 'Event berhasil ditambahkan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Jika terjadi error validasi, kembalikan ke halaman sebelumnya dengan pesan error
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            // Jika terjadi error lain, kembalikan dengan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Fungsi untuk memperbarui data event yang sudah ada
    public function update(Request $request, Event $event)
    {
        try {
            $validatedData = $request->validate([
                'judul' => 'required|string',
                'tanggal' => 'required|date',
                'pesan' => 'required|string|max:255',
                'kategori' => 'required|in:Hari Raya Keagamaan,Hari Nasional,Hari Kerja,Jadwal Atasan',
                'gambar' => 'image|mimes:jpeg,png,jpg,gif',
            ]);

            // Jika ada file gambar baru, hapus gambar lama dan simpan gambar baru
            if ($request->hasFile('gambar')) {
                $destination = "images/poster/" . $event->gambar;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $fileName = time() . $request->file('gambar')->getClientOriginalName();
                $request->file('gambar')->move(public_path('images/poster'), $fileName);
                $validatedData['gambar'] = $fileName;
            }

            $event->update($validatedData);
    
            return redirect()->route('event.index')->with('success', 'Event Berhasil diperbarui');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        try {
            // Cek dan hapus file
            $destination = ('images/poster/' . $event->gambar);
            if (File::exists($destination)) {
                File::delete($destination);
            }

            $event->delete(); // Menghapus event
            return redirect()->route('event.index')->with('success', 'Event berhasil dihapus!'); // Redirect dengan pesan sukses
        } catch (\Exception $e) {
            // Jika terjadi error, redirect dengan pesan error
            return redirect()->route('event.index')->with('error', 'Terjadi kesalahan saat menghapus event: ' . $e->getMessage());
        }
    }
}
