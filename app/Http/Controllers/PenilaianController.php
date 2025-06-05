<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\NilaiAlternatif;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('entries', 5); // Default to 5 entries per page

        // Check if there are any alternatifs at all
        $totalAlternatifs = Alternatif::count();

        $alternatifs = Alternatif::when($search, function ($query) use ($search) {
            $query->where('kode_alternatif', 'like', "%{$search}%")
                ->orWhere('nama_alternatif', 'like', "%{$search}%");
        })
            ->orderBy('kode_alternatif')
            ->paginate($perPage);

        // Get nilai alternatif data for each alternatif
        foreach ($alternatifs as $alternatif) {
            $nilaiCount = NilaiAlternatif::where('id_alternatif', $alternatif->id_alternatif)
                ->count();

            // Check if nilai alternatif exists for this alternatif
            $alternatif->has_nilai = $nilaiCount > 0;
        }

        return view('penilaian.index', compact('alternatifs', 'totalAlternatifs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $alternatif_id = $request->id;
        $alternatif = Alternatif::findOrFail($alternatif_id);
        $kriterias = Kriteria::all();

        // Get subkriteria for each kriteria
        foreach ($kriterias as $kriteria) {
            $kriteria->subkriterias = SubKriteria::where('id_kriteria', $kriteria->id_kriteria)->get();
        }

        return view('penilaian.create', compact('alternatif', 'kriterias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_alternatif' => 'required|exists:alternatifs,id_alternatif',
            'nilai.*' => 'required',
        ]);

        $id_alternatif = $request->id_alternatif;
        $nilai_data = $request->nilai;

        foreach ($nilai_data as $id_kriteria => $id_subkriteria) {
            // Get subkriteria data
            $subkriteria = SubKriteria::findOrFail($id_subkriteria);

            // Create nilai alternatif
            NilaiAlternatif::create([
                'id_alternatif' => $id_alternatif,
                'id_kriteria' => $id_kriteria,
                'nilai_subkriteria' => $subkriteria->nama_subkriteria,
                'bobot_subkriteria' => $subkriteria->nilai,
            ]);
        }

        return redirect()->route('penilaian.index')
            ->with('success', 'Data Penilaian Berhasil Disimpan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $alternatif_id = $request->id;
        $alternatif = Alternatif::findOrFail($alternatif_id);
        $kriterias = Kriteria::all();

        // Get subkriteria for each kriteria
        foreach ($kriterias as $kriteria) {
            $kriteria->subkriterias = SubKriteria::where('id_kriteria', $kriteria->id_kriteria)->get();

            // Get selected nilai for this kriteria and alternatif
            $nilai = NilaiAlternatif::where('id_alternatif', $alternatif_id)
                ->where('id_kriteria', $kriteria->id_kriteria)
                ->first();

            if ($nilai) {
                // Find subkriteria id based on nama_subkriteria
                $selected_subkriteria = SubKriteria::where('id_kriteria', $kriteria->id_kriteria)
                    ->where('nama_subkriteria', $nilai->nilai_subkriteria)
                    ->first();

                $kriteria->selected_subkriteria = $selected_subkriteria ? $selected_subkriteria->id_subkriteria : null;
            }
        }

        return view('penilaian.edit', compact('alternatif', 'kriterias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id_alternatif' => 'required|exists:alternatifs,id_alternatif',
            'nilai.*' => 'required',
        ]);

        $id_alternatif = $request->id_alternatif;
        $nilai_data = $request->nilai;

        // Delete existing nilai alternatif
        NilaiAlternatif::where('id_alternatif', $id_alternatif)->delete();

        // Create new nilai alternatif
        foreach ($nilai_data as $id_kriteria => $id_subkriteria) {
            // Get subkriteria data
            $subkriteria = SubKriteria::findOrFail($id_subkriteria);

            // Create nilai alternatif
            NilaiAlternatif::create([
                'id_alternatif' => $id_alternatif,
                'id_kriteria' => $id_kriteria,
                'nilai_subkriteria' => $subkriteria->nama_subkriteria,
                'bobot_subkriteria' => $subkriteria->nilai,
            ]);
        }

        return redirect()->route('penilaian.index')
            ->with('success', 'Data Penilaian Berhasil Diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the alternatif
            $alternatif = Alternatif::findOrFail($id);

            // Delete all nilai alternatif for this alternatif
            NilaiAlternatif::where('id_alternatif', $id)->delete();

            return redirect()->route('penilaian.index')
                ->with('success', 'Data Penilaian Berhasil Dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('penilaian.index')
                ->with('error', 'Gagal Menghapus Data Penilaian.');
        }
    }
}
