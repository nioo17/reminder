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
            'email' => 'pengguna1@example.com',
            'telegram' => '1234567890',
        ]);

        DB::table('penggunas')->insert([
            'nama' => 'Puyu',
            'email' => 'putriayulestari621@gmail.com',
            'telegram' => '564401018',
        ]);

        DB::table('penggunas')->insert([
            'nama' => 'Nioo',
            'email' => 'antoniowisu17@gmail.com',
            'telegram' => '5151281421',
        ]);

        DB::table('penggunas')->insert([
            'nama' => 'Diantari',
            'email' => 'diantari192003@gmail.com',
            'telegram' => '1271362249',
        ]);
    }
}
