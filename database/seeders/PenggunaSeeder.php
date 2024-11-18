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
        DB::table('penggunas')->insert([
            'nama' => 'Pengguna 1',
            'email' => 'pengguna1@gmail.com',
            'telegram' => '1234567890',
        ]);
    }
}
