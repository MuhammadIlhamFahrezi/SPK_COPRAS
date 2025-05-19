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
                'nama' => 'Tanggungan Orang Tua',
                'bobot' => 20.00,
                'jenis' => 'Benefit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'C2',
                'nama' => 'Prestasi',
                'bobot' => 20.00,
                'jenis' => 'Benefit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'C3',
                'nama' => 'Penghasilan Orang Tua',
                'bobot' => 10.00,
                'jenis' => 'Cost',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'C4',
                'nama' => 'IPK',
                'bobot' => 50.00,
                'jenis' => 'Benefit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert data kriteria
        DB::table('kriterias')->insert($kriterias);
    }
}
