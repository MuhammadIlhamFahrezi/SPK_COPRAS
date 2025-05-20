<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('entries', 10);

        $kriterias = Kriteria::when($search, function ($query) use ($search) {
            $query->where('kode', 'like', "%{$search}%")
                ->orWhere('nama', 'like', "%{$search}%")
                ->orWhere('jenis', 'like', "%{$search}%");
        })
            ->orderBy('kode')
            ->paginate($perPage);

        return view('kriteria.index', compact('kriterias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kriteria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:kriterias,kode|max:10',
            'nama' => 'required|unique:kriterias,nama|max:100',
            'bobot' => 'required|numeric|min:0|max:100',
            'jenis' => 'required|in:Benefit,Cost',
        ], [
            'kode.unique' => 'Kode Kriteria Sudah Digunakan',
            'nama.unique' => 'Nama Kriteria Sudah Digunakan',
        ]);

        // No need to generate ID, it will be auto-incremented
        Kriteria::create($request->all());

        return redirect()->route('kriteria.index')
            ->with('success', 'Data Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $kriteria = Kriteria::findOrFail($id);
        return view('kriteria.show', compact('kriteria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $kriteria = Kriteria::findOrFail($id);
        return view('kriteria.edit', compact('kriteria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $kriteria = Kriteria::findOrFail($id);

        $request->validate([
            'kode' => [
                'required',
                'max:10',
                Rule::unique('kriterias')->ignore($kriteria->id_kriteria, 'id_kriteria')
            ],
            'nama' => [
                'required',
                'max:100',
                Rule::unique('kriterias')->ignore($kriteria->id_kriteria, 'id_kriteria')
            ],
            'bobot' => 'required|numeric|min:0|max:100',
            'jenis' => 'required|in:Benefit,Cost',
        ], [
            'kode.unique' => 'Kode Kriteria Sudah Digunakan',
            'nama.unique' => 'Nama Kriteria Sudah Digunakan',
        ]);

        $kriteria->update($request->all());

        return redirect()->route('kriteria.index')
            ->with('success', 'Data Berhasil DiUpdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $kriteria = Kriteria::findOrFail($id);
        $kriteria->delete();

        return redirect()->route('kriteria.index')
            ->with('success', 'Data Berhasil Dihapus');
    }
}
