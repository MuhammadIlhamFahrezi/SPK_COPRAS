<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CoprasService;
use App\Models\Kriteria;
use App\Models\Alternatif;

class HasilAkhirController extends Controller
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
            return view('hasilakhir.index', [
                'noData' => true,
                'message' => 'Data kriteria atau alternatif masih kosong. Silahkan tambahkan data terlebih dahulu.'
            ]);
        }

        // Get utility degree data (final rankings)
        $utilityDegreeData = $this->coprasService->getUtilityDegree();

        return view('hasilakhir.index', [
            'finalRanking' => $utilityDegreeData['utility'],
            'noData' => false
        ]);
    }
}
