<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
                'telegram' => 'required|numeric|digits_between:9,10|unique:penggunas,telegram',
                'jabatan' => 'required|in:Karyawan,Atasan',
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
                ]
            ]);

        // Simpan pengguna baru
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
                // Telegram ID wajib, berupa angka, dan unik, kecuali untuk pengguna dengan ID saat ini
                'telegram' => [
                    'required',
                    'numeric',
                    'digits_between:9,10',
                    Rule::unique('penggunas', 'telegram')->ignore($id, 'id_pengguna')
                ],
                'jabatan' => 'required|in:Karyawan,Atasan',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('penggunas', 'email')->ignore($id, 'id_pengguna'),
                    function ($atribut, $value, $fail) {
                        $domain = substr(strrchr($value, "@"), 1);
                        if (!in_array($domain, $this->allowedDomains)) {
                            $fail('Domain tidak dikenal. Gunakan domain: ' . implode(', ', $this->allowedDomains) . '.');
                        }
                    }
                ],
                
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
        try {
            $pengguna->delete(); // Menghapus event
            return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil dihapus!'); // Redirect dengan pesan sukses
        } catch (\Exception $e) {
            // Jika terjadi error, redirect dengan pesan error
            return redirect()->route('pengguna.index')->with('error', 'Terjadi kesalahan saat menghapus event: ' . $e->getMessage());
        }
    }
}
