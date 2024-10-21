<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Events;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('event.dataevent', compact('events'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tanggal' => 'required|date',
            'pesan' => 'required|string|max:255',
            'kategori' => 'required|in:hariraya,harinasional,harikeagamaan',
            'gambar' => 'required|string|max:255', // Validasi gambar manual
        ]);

        // Simpan data dari input form
        Event::create($request->all());

        return redirect()->route('event.index')->with('success', 'Event berhasil ditambahkan!'); // Redirect dengan pesan sukses
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        // Validasi input
        $request->validate([
            'tanggal' => 'required|date',
            'pesan' => 'required|string|max:255',
            'kategori' => 'required|in:hariraya,harinasional,harikeagamaan',
            'gambar' => 'required|string|max:255', // Validasi gambar manual
        ]);

        // Update data event
        $event->update($request->all());

        return redirect()->route('event.index')->with('success', 'Event berhasil diperbarui!'); // Redirect dengan pesan sukses
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete(); // Menghapus event
        return redirect()->route('event.index')->with('success', 'Event berhasil dihapus!'); // Redirect dengan pesan sukses
    }
}   
