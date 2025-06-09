<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NilaiAlternatifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua data alternatif dan kriteria
        $alternatifs = DB::table('alternatifs')->get();
        $kriterias = DB::table('kriterias')->get();

        $nilaiAlternatifs = [];

        // Nilai untuk setiap alternatif dan kriteria
        $nilai = [
            'A1' => ['C1' => 3, 'C2' => 3, 'C3' => 2, 'C4' => 5, 'C5' => 3],
            'A2' => ['C1' => 4, 'C2' => 3, 'C3' => 3, 'C4' => 4, 'C5' => 3],
            'A3' => ['C1' => 4, 'C2' => 4, 'C3' => 1, 'C4' => 5, 'C5' => 2],
            'A4' => ['C1' => 4, 'C2' => 3, 'C3' => 3, 'C4' => 3, 'C5' => 5],
            'A5' => ['C1' => 3, 'C2' => 3, 'C3' => 3, 'C4' => 4, 'C5' => 5],
            'A6' => ['C1' => 4, 'C2' => 3, 'C3' => 4, 'C4' => 4, 'C5' => 3],
            'A7' => ['C1' => 3, 'C2' => 3, 'C3' => 4, 'C4' => 4, 'C5' => 3],
        ];

        foreach ($alternatifs as $alt) {
            foreach ($kriterias as $krit) {
                if (!isset($nilai[$alt->kode_alternatif][$krit->kode])) {
                    continue; // Lewati jika tidak ada nilai untuk kombinasi ini
                }

                $nilaiInt = $nilai[$alt->kode_alternatif][$krit->kode];

                $subkriteria = DB::table('sub_kriterias')
                    ->where('id_kriteria', $krit->id_kriteria)
                    ->where('nilai', $nilaiInt)
                    ->first();

                $nilaiAlternatifs[] = [
                    'id_alternatif' => $alt->id_alternatif,
                    'id_kriteria' => $krit->id_kriteria,
                    'nilai_subkriteria' => $subkriteria->nama_subkriteria,
                    'bobot_subkriteria' => $subkriteria->nilai,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Masukkan data ke tabel nilai_alternatifs
        DB::table('nilai_alternatifs')->insert($nilaiAlternatifs);
    }
}
