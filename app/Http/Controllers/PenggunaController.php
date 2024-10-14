<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Data Pengguna';
        $q = $request->query('q');
        $penggunas = Pengguna::where('judul_buku', 'like', '%' . $q . '%')
            // ->leftjoin('tb_kategori', 'tb_kategori.id_kategori', 'tb_buku.id_kategori')
            ->paginate(15)
            ->withQueryString();
        $no = $penggunas->firstItem();
        return view('pengguna.index', compact('title', 'penggunas', 'q', 'no'));
    }
}
