<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlternatifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menyiapkan data alternatif
        $alternatifs = [
            [
                'kode_alternatif' => 'A1',
                'nama_alternatif' => 'Sains Murni',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_alternatif' => 'A2',
                'nama_alternatif' => 'Teknik/Rekayasa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_alternatif' => 'A3',
                'nama_alternatif' => 'Kesehatan/Kedokteran',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_alternatif' => 'A4',
                'nama_alternatif' => 'Bisnis dan Manajemen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_alternatif' => 'A5',
                'nama_alternatif' => 'Ilmu Sosial dan Hukum',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_alternatif' => 'A6',
                'nama_alternatif' => 'Pendidikan dan Keguruan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_alternatif' => 'A7',
                'nama_alternatif' => 'Seni, Desain dan Industri Kreatif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert data alternatif
        DB::table('alternatifs')->insert($alternatifs);
    }
}
