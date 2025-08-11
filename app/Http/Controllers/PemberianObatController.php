<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\PemberianObat;
use App\Models\RekamMedis;
use Illuminate\Http\Request;

class PemberianObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pemberianObats = PemberianObat::with(['rekamMedis', 'obat'])->get();
        $rekamMedis = RekamMedis::with('pasien.user')->get();
        $obats = Obat::all();
        return view('dashboard.pages.pemberian-obat', compact('pemberianObats', 'rekamMedis', 'obats'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rekam_medis_id' => 'required|exists:rekam_medis,id',
            'obat_id'        => 'required|exists:obats,id',
            'dosis'          => 'required|string|max:255',
            'frekuensi'      => 'required|string|max:255',
            'durasi'         => 'required|string|max:255',
        ]);

        PemberianObat::create($request->all());

        return redirect()->route('pemberian-obat.index')->with('success', 'Data pemberian obat berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'rekam_medis_id' => 'required|exists:rekam_medis,id',
            'obat_id'        => 'required|exists:obats,id',
            'dosis'          => 'required|string|max:255',
            'frekuensi'      => 'required|string|max:255',
            'durasi'         => 'required|string|max:255',
        ]);

        $pemberianObat = PemberianObat::findOrFail($id);
        $pemberianObat->update($request->all());

        return redirect()->route('pemberian-obat.index')->with('success', 'Data pemberian obat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pemberianObat = PemberianObat::findOrFail($id);
        $pemberianObat->delete();

        return redirect()->route('pemberian-obat.index')->with('success', 'Data pemberian obat berhasil dihapus.');
    }
}
