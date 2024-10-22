<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Events;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected $event;
    public function __construct(){
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
            // Generate a unique file name
            $fileName = time().$request->file('gambar')->getClientOriginalName();
            // Move the uploaded file to the public/images directory
            $request->file('gambar')->move(public_path('images/poster'), $fileName);
            // Save the product with the file name
            $validatedData['gambar'] = $fileName; 
        }

        Event::create($validatedData);

        // Event::create([
        //     'tanggal' => 'required|date',
        //     'pesan' => 'required|string|max:255',
        //     'kategori' => 'required|in:hariraya,harinasional,harikeagamaan',
        // ]);

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
