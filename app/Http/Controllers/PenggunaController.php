<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenggunaController extends Controller
{
    // Daftar domain email yang diizinkan untuk validasi
    protected $allowedDomains = ['gmail.com', 'yahoo.com', 'outlook.com'];

    // Fungsi untuk menampilkan daftar pengguna
    public function index()
    {
        $penggunas = Pengguna::all();
        return view('pengguna.datapengguna', compact('penggunas'));
    }

    // Fungsi untuk menyimpan data pengguna baru
    public function store(Request $request)
    {
        try {
            // Validasi input form
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    'unique:penggunas,email',
                    function ($atribut, $value, $fail) {
                        // Validasi tambahan untuk memastikan domain email diizinkan
                        $domain = substr(strrchr($value, "@"), 1);
                        if (!in_array($domain, $this->allowedDomains)) {
                            $fail('Domain tidak dikenal. Gunakan domain: ' . implode(', ', $this->allowedDomains) . '.');
                        }
                    },
                ],
                'telegram' => 'required|numeric|digits_between:9,10|unique:penggunas,telegram'
            ]);
        Pengguna::create($validated);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil ditambahkan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            // Jika terjadi kesalahan lain, kembalikan dengan pesan error
            return redirect()->back()->with('error', 'Terjadi Kesalahan: ' . $e->getMessage());
        }    
    }
    
    // Fungsi untuk memperbarui data pengguna
    public function update(Request $request, $id)
    {
        try {
            // Validasi input form untuk pembaruan
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    'unique:penggunas,email',
                    function ($atribut, $value, $fail) {
                        $domain = substr(strrchr($value, "@"), 1);
                        if (!in_array($domain, $this->allowedDomains)) {
                            $fail('Domain tidak dikenal. Gunakan domain: ' . implode(', ', $this->allowedDomains) . '.');
                        }
                    },
                ],
                // Telegram ID wajib, berupa angka, dan unik, kecuali untuk pengguna dengan ID saat ini
                'telegram' => 'required|numeric|digits_between:9,10|unique:penggunas,telegram,' . $id . ',id_pengguna'
            ]);

            // Mencari pengguna berdasarkan ID
            $pengguna = Pengguna::findOrFail($id);

            $pengguna->update($validated);

            return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil diperbarui!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('pengguna.index')->with('error', 'Pengguna tidak ditemukan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
