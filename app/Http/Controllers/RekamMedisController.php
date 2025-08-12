<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function rekamMedisSaya(Request $request)
    {
        $user = $request->user();

        // Asumsi user adalah pasien dan punya relasi ke rekam medis
        $rekamMedis = RekamMedis::where('pasien_id', $user->pasien->id)->latest()->first();

        if (!$rekamMedis) {
            return response()->json(['message' => 'Rekam medis tidak ditemukan'], 404);
        }

        return response()->json([
            'id' => $rekamMedis->id,
            'tanggal' => $rekamMedis->tanggal,
            'diagnosa' => $rekamMedis->diagnosa
        ]);
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

    public function getData()
    {
        $user = Auth::user();

        // Kalau role pasien → hanya ambil rekam medis milik pasien tersebut
        if ($user->role === 'pasien') {
            $data = RekamMedis::with(['pasien.user', 'petugas'])
                ->whereHas('pasien', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->orderBy('tanggal_periksa', 'desc')
                ->get();
        }
        // Kalau role petugas → ambil semua data
        else {
            $pasienIds = RekamMedis::distinct()->pluck('pasien_id');
            $pasienList = Pasien::with('user')->whereIn('id', $pasienIds)->get();
            return response()->json($pasienList);
        }

        return response()->json($data);
    }

    public function storeData(Request $request)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'keluhan' => 'required|string',
            'diagnosa' => 'required|string',
            'catatan' => 'nullable|string',
            'lokasi' => 'required|string',
            'tanggal_periksa' => 'required|date'
        ]);

        $validated['petugas_id'] = auth::id();

        $rekamMedis = RekamMedis::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Rekam medis berhasil ditambahkan',
            'data' => $rekamMedis
        ], 201);
    }

    public function getByPasien($pasienId)
    {
        $rekamMedis = RekamMedis::where('pasien_id', $pasienId)
            ->orderBy('tanggal_periksa', 'desc')
            ->get();

        return response()->json($rekamMedis);
    }
}
