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
            'Peluang Kerja' => [
                5 => 'Sangat tinggi',
                4 => 'Tinggi',
                3 => 'Sedang',
                2 => 'Rendah',
                1 => 'Sangat rendah',
            ],
            'Minat dan Bakat Pribadi' => [
                5 => 'Sangat sesuai',
                4 => 'Sesuai',
                3 => 'Cukup sesuai',
                2 => 'Tidak sesuai',
                1 => 'Sangat tidak sesuai',
            ],
            'Kesesuaian Gaya Belajar' => [
                5 => 'Sangat sesuai',
                4 => 'Sesuai',
                3 => 'Cukup sesuai',
                2 => 'Tidak sesuai',
                1 => 'Sangat tidak sesuai',
            ],
            'Tingkat Kesulitan Studi' => [
                5 => 'Sangat tinggi',
                4 => 'Tinggi',
                3 => 'Sedang',
                2 => 'Rendah',
                1 => 'Sangat rendah',
            ],
            'Biaya Pendidikan' => [
                5 => 'Sangat terjangkau',
                4 => 'Terjangkau',
                3 => 'Cukup terjangkau',
                2 => 'Tidak terjangkau',
                1 => 'Sangat tidak terjangkau',
            ],
        ];

        return $nameSets[$kriteriaName][$nilai] ?? "Nilai $nilai";
    }
}
