<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Data Pengguna';
        $penggunas = Pengguna::all();
        return view('pengguna.datapengguna', compact('title', 'penggunas'));
    }
}
