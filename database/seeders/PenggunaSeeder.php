<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pengguna')->insert([
            'nama' => 'Test User',
            'email' => 'test@example.com',
            'id_telegram' => '1234567890',
        ]);
    }
}
