<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('user.login');
    }

    public function login(Request $request)
    {
        try {
            // Validasi input dengan regex untuk email dan password
            $credentials = $request->validate([
                'email' => [
                    'required',
                    'email',
                    'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
                ],
                'password' => [
                    'required',
                    'min:2',
                    'regex:/^(?=.*[a-z])(?=.*\d)[a-z\d]{2,}$/'
                ],
            ]);
            
    
            // Cari pengguna berdasarkan email
            $user = User::where('email', $credentials['email'])->first();
    
            if ($user) {
                if (Hash::check($credentials['password'], $user->password)) {
                    Auth::login($user);
                    $request->session()->regenerate();
                    return redirect()->intended('dashboard');
                } else {
                    return redirect()->back()->with('gagal', 'Password anda salah')->withInput();
                }
            } else {
                return redirect()->back()->with('gagal', 'Email belum terdaftar')->withInput();
            }
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

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
