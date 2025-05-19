<?php

namespace App\Services;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\NilaiAlternatif;
use Illuminate\Support\Facades\DB;

class CoprasService
{
    /**
     * Get all criteria data
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getKriteria()
    {
        return Kriteria::all();
    }

    /**
     * Get all alternatives data
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAlternatif()
    {
        return Alternatif::all();
    }

    /**
     * Get decision matrix data
     * 
     * @return array
     */
    public function getMatriksKeputusan()
    {
        $alternatifs = $this->getAlternatif();
        $kriterias = $this->getKriteria();
        $matriks = [];
        $total = [];

        // Initialize total array with zeros
        foreach ($kriterias as $kriteria) {
            $total[$kriteria->id_kriteria] = 0;
        }

        foreach ($alternatifs as $alternatif) {
            $row = [
                'id_alternatif' => $alternatif->id_alternatif,
                'kode_alternatif' => $alternatif->kode_alternatif,
                'nama_alternatif' => $alternatif->nama_alternatif,
                'nilai' => []
            ];

            // Get nilai for each kriteria
            foreach ($kriterias as $kriteria) {
                $nilai = NilaiAlternatif::where('id_alternatif', $alternatif->id_alternatif)
                    ->where('id_kriteria', $kriteria->id_kriteria)
                    ->first();

                $bobot = $nilai ? $nilai->bobot_subkriteria : 0;
                $row['nilai'][$kriteria->id_kriteria] = $bobot;

                // Add to total
                $total[$kriteria->id_kriteria] += $bobot;
            }

            $matriks[] = $row;
        }

        return [
            'matriks' => $matriks,
            'total' => $total
        ];
    }

    /**
     * Calculate normalized matrix
     * 
     * @return array
     */
    public function getNormalisasiMatriks()
    {
        $matriksData = $this->getMatriksKeputusan();
        $matriks = $matriksData['matriks'];
        $total = $matriksData['total'];
        $kriterias = $this->getKriteria();
        $normalisasi = [];

        foreach ($matriks as $row) {
            $normRow = [
                'id_alternatif' => $row['id_alternatif'],
                'kode_alternatif' => $row['kode_alternatif'],
                'nama_alternatif' => $row['nama_alternatif'],
                'nilai' => []
            ];

            foreach ($kriterias as $kriteria) {
                $id_kriteria = $kriteria->id_kriteria;
                // Avoid division by zero
                if ($total[$id_kriteria] == 0) {
                    $normRow['nilai'][$id_kriteria] = 0;
                } else {
                    $normRow['nilai'][$id_kriteria] = round($row['nilai'][$id_kriteria] / $total[$id_kriteria], 4);
                }
            }

            $normalisasi[] = $normRow;
        }

        return $normalisasi;
    }

    /**
     * Get criteria weights (normalized to sum to 1)
     * 
     * @return array
     */
    public function getBobotKriteria()
    {
        $kriterias = $this->getKriteria();
        $bobot = [];
        $totalBobot = 0;

        // Calculate total weight
        foreach ($kriterias as $kriteria) {
            $totalBobot += $kriteria->bobot;
        }

        // Normalize weights to sum to 1
        foreach ($kriterias as $kriteria) {
            if ($totalBobot > 0) {
                $bobot[$kriteria->id_kriteria] = round($kriteria->bobot / $totalBobot, 2);
            } else {
                $bobot[$kriteria->id_kriteria] = 0;
            }
        }

        return $bobot;
    }

    /**
     * Calculate weighted normalized matrix
     * 
     * @return array
     */
    public function getMatriksTernormalisasiTerbobot()
    {
        $normalisasi = $this->getNormalisasiMatriks();
        $bobotKriteria = $this->getBobotKriteria();
        $kriterias = $this->getKriteria();
        $terbobot = [];

        foreach ($normalisasi as $row) {
            $terbobotRow = [
                'id_alternatif' => $row['id_alternatif'],
                'kode_alternatif' => $row['kode_alternatif'],
                'nama_alternatif' => $row['nama_alternatif'],
                'nilai' => []
            ];

            foreach ($kriterias as $kriteria) {
                $id_kriteria = $kriteria->id_kriteria;
                $terbobotRow['nilai'][$id_kriteria] = round($row['nilai'][$id_kriteria] * $bobotKriteria[$id_kriteria], 4);
            }

            $terbobot[] = $terbobotRow;
        }

        return $terbobot;
    }

    /**
     * Calculate the sum of beneficial criteria (S+)
     * 
     * @return array
     */
    public function getJumlahKriteriaBenefit()
    {
        $terbobot = $this->getMatriksTernormalisasiTerbobot();
        $kriterias = $this->getKriteria();
        $resultSPlus = [];

        foreach ($terbobot as $row) {
            $sPlus = 0;

            foreach ($kriterias as $kriteria) {
                $id_kriteria = $kriteria->id_kriteria;
                // If benefit (Benefit)
                if (strtolower($kriteria->jenis) == 'benefit') {
                    $sPlus += $row['nilai'][$id_kriteria];
                }
            }

            $resultSPlus[] = [
                'id_alternatif' => $row['id_alternatif'],
                'kode_alternatif' => $row['kode_alternatif'],
                'nama_alternatif' => $row['nama_alternatif'],
                'nilai' => round($sPlus, 4)
            ];
        }

        return $resultSPlus;
    }

    /**
     * Calculate the sum of non-beneficial criteria (S-)
     * 
     * @return array
     */
    public function getJumlahKriteriaCost()
    {
        $terbobot = $this->getMatriksTernormalisasiTerbobot();
        $kriterias = $this->getKriteria();
        $resultSMinus = [];
        $totalSMinus = 0;

        foreach ($terbobot as $row) {
            $sMinus = 0;

            foreach ($kriterias as $kriteria) {
                $id_kriteria = $kriteria->id_kriteria;
                // If cost (Cost)
                if (strtolower($kriteria->jenis) == 'cost') {
                    $sMinus += $row['nilai'][$id_kriteria];
                }
            }

            $resultSMinus[] = [
                'id_alternatif' => $row['id_alternatif'],
                'kode_alternatif' => $row['kode_alternatif'],
                'nama_alternatif' => $row['nama_alternatif'],
                'nilai' => round($sMinus, 4)
            ];

            $totalSMinus += $sMinus;
        }

        return [
            'sMinus' => $resultSMinus,
            'total' => round($totalSMinus, 4)
        ];
    }

    /**
     * Calculate relative weights (Q)
     * 
     * @return array
     */
    public function getRelativeWeight()
    {
        $sPlus = $this->getJumlahKriteriaBenefit();
        $sMinusData = $this->getJumlahKriteriaCost();
        $sMinus = $sMinusData['sMinus'];
        $totalSMinus = $sMinusData['total'];

        $relativeWeights = [];

        // Calculate sum of 1/S-
        $sumInverse = 0;
        foreach ($sMinus as $row) {
            if ($row['nilai'] > 0) {
                $sumInverse += 1 / $row['nilai'];
            }
        }

        for ($i = 0; $i < count($sPlus); $i++) {
            $q = 0;

            // FIX: Correct formula for Q calculation
            // Q = S+ + (S-min * sum(1/S-)) / (S- * sum(1/S-))
            if ($sMinus[$i]['nilai'] > 0) {
                // S+ part
                $q = $sPlus[$i]['nilai'];

                // S- part (only if S- value > 0)
                $q += ($totalSMinus / $sMinus[$i]['nilai']) / $sumInverse;
            } else {
                $q = $sPlus[$i]['nilai'];
            }

            $relativeWeights[] = [
                'id_alternatif' => $sPlus[$i]['id_alternatif'],
                'kode_alternatif' => $sPlus[$i]['kode_alternatif'],
                'nama_alternatif' => $sPlus[$i]['nama_alternatif'],
                'inverse' => $sMinus[$i]['nilai'] > 0 ? round(1 / $sMinus[$i]['nilai'], 4) : 0,
                'nilai' => round($q, 4)
            ];
        }

        return [
            'weights' => $relativeWeights,
            'sumInverse' => round($sumInverse, 4)
        ];
    }

    /**
     * Calculate utility degree (U)
     * 
     * @return array
     */
    public function getUtilityDegree()
    {
        $relativeWeightData = $this->getRelativeWeight();
        $relativeWeights = $relativeWeightData['weights'];

        // Find maximum Q value
        $maxQ = 0;
        foreach ($relativeWeights as $row) {
            if ($row['nilai'] > $maxQ) {
                $maxQ = $row['nilai'];
            }
        }

        $utilityDegrees = [];

        foreach ($relativeWeights as $row) {
            // Calculate utility degree (U = Q / Qmax * 100%)
            $u = ($maxQ > 0) ? ($row['nilai'] / $maxQ) * 100 : 0;

            $utilityDegrees[] = [
                'id_alternatif' => $row['id_alternatif'],
                'kode_alternatif' => $row['kode_alternatif'],
                'nama_alternatif' => $row['nama_alternatif'],
                'nilai_q' => $row['nilai'],
                'nilai_u' => round($u, 2)
            ];
        }

        // Sort by utility value (descending)
        usort($utilityDegrees, function ($a, $b) {
            return $b['nilai_u'] <=> $a['nilai_u'];
        });

        // Add ranking
        $rank = 1;
        foreach ($utilityDegrees as &$row) {
            $row['rank'] = $rank++;
        }

        return [
            'maxQ' => $maxQ,
            'utility' => $utilityDegrees
        ];
    }

    /**
     * Get all calculation results
     * 
     * @return array
     */
    public function getAllCalculations()
    {
        return [
            'kriterias' => $this->getKriteria(),
            'alternatifs' => $this->getAlternatif(),
            'matriksKeputusan' => $this->getMatriksKeputusan(),
            'bobotKriteria' => $this->getBobotKriteria(),
            'normalisasiMatriks' => $this->getNormalisasiMatriks(),
            'matriksTernormalisasiTerbobot' => $this->getMatriksTernormalisasiTerbobot(),
            'sPlus' => $this->getJumlahKriteriaBenefit(),
            'sMinusData' => $this->getJumlahKriteriaCost(),
            'relativeWeightData' => $this->getRelativeWeight(),
            'utilityDegreeData' => $this->getUtilityDegree()
        ];
    }
}
