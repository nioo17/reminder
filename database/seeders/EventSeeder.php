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
            'tanggal' => '2005-01-17',
            'pesan' => 'ulang tahun saya',
            'gambar' => 'eror',
            'kategori' => 'hariraya'
        ]);
    }
}
