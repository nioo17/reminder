<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenggunaController extends Controller
{
    public function store(Request $request)
    {
        $penggunas = Pengguna::all();
        return view('pengguna.datapengguna', compact('penggunas'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'telegram' => 'required|string|max:10'
        ]);

        // Simpan data dari input form
        Pengguna::create($request->all());

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil ditambahkan!'); // Redirect dengan pesan sukses
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengguna $pengguna)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'telegramid' => 'required|string|max:10'
        ]);

        // Update data event
        $pengguna->update($request->all());

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil diperbarui!'); // Redirect dengan pesan sukses
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengguna $pengguna)
    {
        $pengguna->delete(); // Menghapus event
        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil dihapus!'); // Redirect dengan pesan sukses
    }
}
