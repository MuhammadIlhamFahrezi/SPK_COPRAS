<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubKriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('entries', 5);

        // Get all kriterias with their sub-kriterias
        $kriterias = Kriteria::with(['subkriterias' => function ($query) use ($search) {
            if ($search) {
                $query->where('nama_subkriteria', 'like', "%{$search}%")
                    ->orWhere('nilai', 'like', "%{$search}%");
            }
        }])->orderBy('kode')->get();

        return view('subkriteria.index', compact('kriterias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $kriteriaId = $request->input('kriteria_id');
        $kriteria = Kriteria::findOrFail($kriteriaId);

        return view('subkriteria.create', compact('kriteria'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_kriteria' => 'required|exists:kriterias,id_kriteria',
            'nama_subkriteria' => [
                'required',
                'max:100',
                Rule::unique('sub_kriterias')
                    ->where(function ($query) use ($request) {
                        return $query->where('id_kriteria', $request->id_kriteria);
                    })
            ],
            'nilai' => 'required|integer|min:1',
        ], [
            'nama_subkriteria.unique' => 'Nama Sub Kriteria sudah digunakan',
            'nilai.min' => 'Nilai tidak boleh 0',
        ]);

        SubKriteria::create($validated);

        return redirect()->route('subkriteria.index')
            ->with('success', 'Data Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $subkriteria = SubKriteria::with('kriteria')->findOrFail($id);
        return view('subkriteria.show', compact('subkriteria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $subkriteria = SubKriteria::findOrFail($id);
        $kriteria = $subkriteria->kriteria;

        return view('subkriteria.edit', compact('subkriteria', 'kriteria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $subkriteria = SubKriteria::findOrFail($id);

        $validated = $request->validate([
            'nama_subkriteria' => [
                'required',
                'max:100',
                Rule::unique('sub_kriterias', 'nama_subkriteria')
                    ->where(function ($query) use ($subkriteria) {
                        return $query->where('id_kriteria', $subkriteria->id_kriteria);
                    })
                    ->ignore($id, 'id_subkriteria')
            ],
            'nilai' => 'required|integer|min:1',
        ], [
            'nama_subkriteria.unique' => 'Nama Sub Kriteria sudah digunakan',
            'nilai.min' => 'Nilai harus lebih dari 0',
        ]);

        $subkriteria->update($validated);

        return redirect()->route('subkriteria.index')
            ->with('success', 'Data Berhasil DiUpdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $subkriteria = SubKriteria::findOrFail($id);
        $subkriteria->delete();

        return redirect()->route('subkriteria.index')
            ->with('success', 'Data Berhasil Dihapus');
    }
}
