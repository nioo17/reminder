<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class EventController extends Controller
{
    protected $event;
    public function __construct()
    {
        $this->event = new Event();
    }
    public function index()
    {
        $events = Event::all();
        return view('event.dataevent', compact('events'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'pesan' => 'required|string|max:255',
            'kategori' => 'required|in:hariraya,harinasional,harikeagamaan',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:255', // Validasi gambar manual
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
        // Validasi input
        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'pesan' => 'required|string|max:255',
            'kategori' => 'required|in:hariraya,harinasional,harikeagamaan',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif',
            // 'gambar' => 'required|string|max:255', // Validasi gambar manual
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

        // Update data event
        $event->update($validatedData);

        return redirect()->route('event.index')->with('success', 'Event berhasil diperbarui!'); // Redirect dengan pesan sukses
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
