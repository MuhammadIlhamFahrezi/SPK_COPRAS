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
                'kriterias' => collect(),
                'alternatifs' => collect(),
                'finalRanking' => collect()
            ]);
        }

        // Get utility degree data (final rankings)
        $utilityDegreeData = $this->coprasService->getUtilityDegree();

        return view('hasilakhir.index', [
            'kriterias' => $kriterias,
            'alternatifs' => $alternatifs,
            'finalRanking' => $utilityDegreeData['utility'],
            'noData' => false
        ]);
    }
}
