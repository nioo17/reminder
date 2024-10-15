<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Data Pengguna';
        // $q = $request->query('q');
        $penggunas = Pengguna::get();
        $no = $penggunas->firstItem();
        return view('pengguna.datapengguna', compact('title', 'penggunas', 'no'));
    }
}
