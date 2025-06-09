<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menyiapkan data kriteria
        $kriterias = [
            [
                'kode' => 'C1',
                'nama' => 'Peluang Kerja',
                'bobot' => 7.00,
                'jenis' => 'Benefit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'C2',
                'nama' => 'Minat dan Bakat Pribadi',
                'bobot' => 4.00,
                'jenis' => 'Benefit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'C3',
                'nama' => 'Kesesuaian Gaya Belajar',
                'bobot' => 48.00,
                'jenis' => 'Benefit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'C4',
                'nama' => 'Tingkat Kesulitan Studi',
                'bobot' => 9.00,
                'jenis' => 'Cost',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'C5',
                'nama' => 'Biaya Pendidikan',
                'bobot' => 32.00,
                'jenis' => 'Cost',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert data kriteria
        DB::table('kriterias')->insert($kriterias);
    }
}
