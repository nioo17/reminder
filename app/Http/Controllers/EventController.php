<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('event.dataevent', compact('events'));
    }

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
        
        return response()->json($calendarEvents);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'judul' => 'required|string',
            'tanggal' => 'required|date',
            'pesan' => 'required|string|max:255',
            'kategori' => 'required|in:Hari Raya Keagamaan,Hari Nasional,Hari Kerja,Jadwal Atasan',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:255' // Validasi gambar manual
        ]);

        if ($request->hasFile('gambar')) {
            $fileName = time() . $request->file('gambar')->getClientOriginalName();
            $request->file('gambar')->move(public_path('images/poster'), $fileName);
            $validatedData['gambar'] = $fileName;
        }

        Event::create($validatedData);

        return redirect()->route('event.index')->with('success', 'Event berhasil ditambahkan!'); // Redirect dengan pesan sukses
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string',
            'tanggal' => 'required|date',
            'pesan' => 'required|string|max:255',
            'kategori' => 'required|in:Hari Raya Keagamaan,Hari Nasional,Hari Kerja,Jadwal Atasan',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif',
        ]);

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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //  nih disini delete filenya
        $destination = ('images/poster/' . $event->gambar);
        if (File::exists($destination)) {
            File::delete($destination);
        }
        // dd($event['gambar']);
        $event->delete(); // Menghapus event
        return redirect()->route('event.index')->with('success', 'Event berhasil dihapus!'); // Redirect dengan pesan sukses
    }
}
