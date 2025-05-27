<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AlternatifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('entries', 5);

        $alternatifs = Alternatif::when($search, function ($query) use ($search) {
            $query->where('kode_alternatif', 'like', "%{$search}%")
                ->orWhere('nama_alternatif', 'like', "%{$search}%");
        })
            ->orderBy('kode_alternatif')
            ->paginate($perPage);

        return view('alternatif.index', compact('alternatifs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('alternatif.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_alternatif' => 'required|unique:alternatifs,kode_alternatif|max:10',
            'nama_alternatif' => 'required|unique:alternatifs,nama_alternatif|max:100',
        ], [
            'kode_alternatif.unique' => 'Kode Alternatif Sudah Digunakan',
            'nama_alternatif.unique' => 'Nama Alternatif Sudah Digunakan',
        ]);

        // No need to generate ID, it will be auto-incremented
        Alternatif::create($request->all());

        return redirect()->route('alternatif.index')
            ->with('success', 'Data Alternatif Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $alternatif = Alternatif::findOrFail($id);
        return view('alternatif.show', compact('alternatif'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $alternatif = Alternatif::findOrFail($id);
        return view('alternatif.edit', compact('alternatif'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $alternatif = Alternatif::findOrFail($id);

        $request->validate([
            'kode_alternatif' => [
                'required',
                'max:10',
                Rule::unique('alternatifs')->ignore($alternatif->id_alternatif, 'id_alternatif')
            ],
            'nama_alternatif' => [
                'required',
                'max:100',
                Rule::unique('alternatifs')->ignore($alternatif->id_alternatif, 'id_alternatif')
            ],
        ], [
            'kode_alternatif.unique' => 'Kode Alternatif Sudah Digunakan',
            'nama_alternatif.unique' => 'Nama Alternatif Sudah Digunakan',
        ]);

        $alternatif->update($request->all());

        return redirect()->route('alternatif.index')
            ->with('success', 'Data Alternatif Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $alternatif = Alternatif::findOrFail($id);
        $alternatif->delete();

        return redirect()->route('alternatif.index')
            ->with('success', 'Data Alternatif Berhasil Dihapus');
    }
}
