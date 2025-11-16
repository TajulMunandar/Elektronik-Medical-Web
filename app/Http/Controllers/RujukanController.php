<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use App\Models\Rujukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RujukanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rujukans = Rujukan::with('rekamMedis.pasien.user', 'rekamMedis.petugas')->latest()->get();
        $rekamMedis = RekamMedis::with('pasien.user', 'petugas')->get();

        return view('dashboard.pages.rujukan', compact('rujukans', 'rekamMedis'));
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
        $validated = $request->validate([
            'rekam_medis_id' => 'required|exists:rekam_medis,id',
            'dari_faskes'    => 'required|in:puskesmas,rumah_sakit',
            'ke_faskes'      => 'required|in:puskesmas,rumah_sakit',
            'alasan_rujukan' => 'required|string',
            'tanggal_rujukan' => 'required|date',
        ]);

        Rujukan::create($validated);

        return redirect()->route('rujukan.index')->with('success', 'Data rujukan berhasil ditambahkan.');
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
        $validated = $request->validate([
            'rekam_medis_id' => 'required|exists:rekam_medis,id',
            'dari_faskes'    => 'required|in:puskesmas,rumah_sakit',
            'ke_faskes'      => 'required|in:puskesmas,rumah_sakit',
            'alasan_rujukan' => 'required|string',
            'tanggal_rujukan' => 'required|date',
        ]);

        $rujukan = Rujukan::findOrFail($id);
        $rujukan->update($validated);

        return redirect()->route('rujukan.index')->with('success', 'Data rujukan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rujukan = Rujukan::findOrFail($id);
        $rujukan->delete();

        return redirect()->route('rujukan.index')->with('success', 'Data rujukan berhasil dihapus.');
    }


    public function getData()
    {
        $user = Auth::user();
        if ($user->role === 'pasien') {
            // Ambil hanya rujukan milik pasien yang login
            $data = Rujukan::with('rekamMedis.pasien.user')
                ->whereHas('rekamMedis.pasien', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->orderBy('tanggal_rujukan', 'desc')
                ->get();
        } else {
            // Kalau petugas → ambil semua rujukan
            $data = Rujukan::with('rekamMedis.pasien.user')
                ->orderBy('tanggal_rujukan', 'desc')
                ->get();
        }

        return response()->json($data);
    }

    // Simpan rujukan baru
    public function storeData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rekam_medis_id' => 'required|exists:rekam_medis,id',
            'dari_faskes' => 'required|in:puskesmas,rumah_sakit',
            'ke_faskes' => 'required|in:puskesmas,rumah_sakit',
            'alasan_rujukan' => 'required|string',
            'tanggal_rujukan' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $rujukan = Rujukan::create($request->all());

        return response()->json([
            'message' => 'Rujukan berhasil ditambahkan',
            'data' => $rujukan,
        ], 201);
    }
}
