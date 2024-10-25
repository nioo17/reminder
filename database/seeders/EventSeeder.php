<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('events')->insert([
            'judul' => 'Purnama',
            'tanggal' => '2025-01-13',
            'pesan' => 'Rahajeng Purnama',
            'gambar' => '',
            'kategori' => 'Hari Raya Keagamaan'
        ]);
    }
}
