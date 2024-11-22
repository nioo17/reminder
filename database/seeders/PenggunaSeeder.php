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
            'nama' => 'Puyu',
            'email' => 'putriayulestari621@gmail.com',
            'telegram' => '564401018',
            'jabatan' => 'Atasan'
        ]);

        DB::table('penggunas')->insert([
            'nama' => 'Diantari',
            'email' => 'diantari192003@gmail.com',
            'telegram' => '1302482058',
            'jabatan' => 'Karyawan'
        ]);

        DB::table('penggunas')->insert([
            'nama' => 'Nioo',
            'email' => 'antoniowisu17@gmail.com',
            'telegram' => '5151281421',
            'jabatan' => 'Karyawan'
        ]);

        DB::table('penggunas')->insert([
            'nama' => 'Basuki',
            'email' => 'basukiwahid1@gmail.com',
            'telegram' => '6562882427',
            'jabatan' => 'Karyawan'
        ]);
    }
}
