<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CoprasService;
use App\Models\Kriteria;
use App\Models\Alternatif;

class PerhitunganController extends Controller
{
    protected $coprasService;

    public function __construct(CoprasService $coprasService)
    {
        $this->coprasService = $coprasService;
    }

    public function index()
    {
        $kriterias = Kriteria::all();
        $alternatifs = Alternatif::all();

        // Check if data exists for calculation
        if ($kriterias->isEmpty() || $alternatifs->isEmpty()) {
            return view('perhitungan.index', [
                'noData' => true,
                'message' => 'Data kriteria atau alternatif masih kosong. Silahkan tambahkan data terlebih dahulu.'
            ]);
        }

        // Get all calculation results
        $calculations = $this->coprasService->getAllCalculations();

        return view('perhitungan.index', [
            'kriterias' => $calculations['kriterias'],
            'alternatifs' => $calculations['alternatifs'],
            'matriksKeputusan' => $calculations['matriksKeputusan'],
            'bobotKriteria' => $calculations['bobotKriteria'],
            'normalisasiMatriks' => $calculations['normalisasiMatriks'],
            'matriksTernormalisasiTerbobot' => $calculations['matriksTernormalisasiTerbobot'],
            'sPlus' => $calculations['sPlus'],
            'sMinusData' => $calculations['sMinusData'],
            'relativeWeightData' => $calculations['relativeWeightData'],
            'utilityDegreeData' => $calculations['utilityDegreeData'],
            'noData' => false
        ]);
    }
}
