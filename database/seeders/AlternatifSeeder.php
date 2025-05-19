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
                'nama_alternatif' => 'Alternatif A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_alternatif' => 'A2',
                'nama_alternatif' => 'Alternatif B',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_alternatif' => 'A3',
                'nama_alternatif' => 'Alternatif C',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_alternatif' => 'A4',
                'nama_alternatif' => 'Alternatif D',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_alternatif' => 'A5',
                'nama_alternatif' => 'Alternatif E',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert data alternatif
        DB::table('alternatifs')->insert($alternatifs);
    }
}
