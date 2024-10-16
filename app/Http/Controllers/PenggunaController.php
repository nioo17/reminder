<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenggunaController extends Controller
{
    public function index()
    {
        // $penggunas = DB::table('pengguna')->get();
        $penggunas = Pengguna::all();
        return view('pengguna.datapengguna', compact('penggunas'));
    }
}
