<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubKriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mendapatkan id dari kriteria
        $kriterias = DB::table('kriterias')->get();

        $subKriterias = [];

        // Untuk setiap kriteria, buat 5 subkriteria dengan nilai 1-5
        foreach ($kriterias as $kriteria) {
            for ($i = 1; $i <= 5; $i++) {
                $subKriterias[] = [
                    'id_kriteria' => $kriteria->id_kriteria,
                    'nama_subkriteria' => $this->getSubKriteriaName($kriteria->nama, $i),
                    'nilai' => $i,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert data subkriteria
        DB::table('sub_kriterias')->insert($subKriterias);
    }

    /**
     * Mendapatkan nama subkriteria berdasarkan nama kriteria dan nilai
     */
    private function getSubKriteriaName(string $kriteriaName, int $nilai): string
    {
        $nameSets = [
            'Tanggungan Orang Tua' => [
                5 => '>7',
                4 => '6-7',
                3 => '4-5',
                2 => '2-3',
                1 => '<2',
            ],
            'Prestasi' => [
                5 => 'Nasional',
                4 => 'Provinsi',
                3 => 'Kabupaten',
                2 => 'Kecamatan',
                1 => 'Lokal',
            ],
            'Penghasilan Orang Tua' => [
                5 => '<12.000.000',
                4 => '12.000.000 - 18.000.000',
                3 => '18.000.001 - 24.000.000',
                2 => '24.000.001 - 36.000.000',
                1 => '>36.000.000',
            ],
            'IPK' => [
                5 => '>3,5',
                4 => '3,1 - 3,5',
                3 => '2,6 - 3,0',
                2 => '2,0 - 2,5',
                1 => '<2,0',
            ],
        ];

        return $nameSets[$kriteriaName][$nilai] ?? "Nilai $nilai";
    }
}
