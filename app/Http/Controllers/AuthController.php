<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Fungsi untuk menampilkan halaman login kepada pengguna
    public function showLoginForm()
    {
        return view('user.login');
    }

    // Fungsi untuk menangani proses login pengguna
    function login(Request $request) : object {
        // Menangani eror menggunakan try catch
        try {
            // Validasi input email dan password dari pengguna
            $data = $request->validate([
                'email' => [
                    'required',
                    'email',
                    'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
                ],
                'password' => [
                    'required',
                    'min:2',
                    // Password hanya boleh terdiri dari huruf kecil, angka, dan tanda tertentu untuk menghindari karakter yang berbahaya
                    'regex:/^(?=.*[a-z])(?=.*\d)[a-z\d!@#$%^&*()_+|~=`{}\[\]:";\'<>?,.\/-]{2,}$/i'
                ],
            ]);
            
            // Cari pengguna berdasarkan email yang diberikan
            $user = User::where('email', $data['email'])->first();

            // Jika pengguna tidak ditemukan atau kredensial tidak valid, kembali ke halaman login dengan pesan error
            if (!$user || !Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                return redirect()->route('login')->with('gagal', 'Invalid Credentials');
            }

            // Regenerasi session setelah login berhasil untuk keamanan
            $request->session()->regenerate();

            // Redirect pengguna ke dashboard dengan pesan sukses
            return redirect()->route('dashboard')->with('success', 'Login Berhasil');
        } catch (\Exception $th) {
            // Jika terjadi error, kembali ke halaman sebelumnya dengan pesan error
            return redirect()->back()->with(
                'gagal', $th->getMessage()
            );
        }
    }
    
    // Fungsi untuk menangani proses logout pengguna
    public function logout(Request $request)
    {
        try {
            // Logout dan hapus session
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
        } catch (\Exception $e) {
            // Tangani error logout jika terjadi
            return redirect()->back()->with('gagal', 'Gagal logout: ' . $e->getMessage());
        }
    }
}
