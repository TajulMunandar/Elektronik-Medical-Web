<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\User;
use Illuminate\Http\Request;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rekamMedis = RekamMedis::with(['pasien', 'petugas'])->get();
        $pasiens = Pasien::all();
        $petugas = User::where('role', 'petugas')->get();

        return view('dashboard.pages.rekam-medis', compact('rekamMedis', 'pasiens', 'petugas'));
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
            'pasien_id' => 'required|exists:pasiens,id',
            'petugas_id' => 'required|exists:users,id',
            'tanggal_periksa' => 'required|date',
            'keluhan' => 'required|string',
            'diagnosa' => 'required|string',
            'catatan_tambahan' => 'nullable|string',
            'lokasi' => 'required|in:puskesmas,rumah_sakit',
        ]);

        RekamMedis::create($request->all());

        return redirect()->route('rekam-medis.index')->with('success', 'Rekam medis berhasil ditambahkan');
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
            'pasien_id' => 'required|exists:pasiens,id',
            'petugas_id' => 'required|exists:users,id',
            'tanggal_periksa' => 'required|date',
            'keluhan' => 'required|string',
            'diagnosa' => 'required|string',
            'catatan_tambahan' => 'nullable|string',
            'lokasi' => 'required|in:puskesmas,rumah_sakit',
        ]);

        $rekamMedis = RekamMedis::findOrFail($id);
        $rekamMedis->update($request->all());

        return redirect()->route('rekam-medis.index')->with('success', 'Rekam medis berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rekamMedis = RekamMedis::findOrFail($id);
        $rekamMedis->delete();

        return redirect()->route('rekam-medis.index')->with('success', 'Rekam medis berhasil dihapus');
    }
}
