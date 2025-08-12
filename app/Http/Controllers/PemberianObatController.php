<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\PemberianObat;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function getData()
    {
        $user = Auth::user();

        if ($user->role === 'pasien') {
            // Ambil hanya obat dari rekam medis pasien ini
            $data = PemberianObat::with(['rekamMedis.pasien.user', 'rekamMedis.petugas', 'obat'])
                ->whereHas('rekamMedis.pasien', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Petugas lihat semua
            $data = PemberianObat::with(['rekamMedis.pasien.user', 'rekamMedis.petugas', 'obat'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return response()->json($data);
    }

    public function storeData(Request $request)
    {
        $validated = $request->validate([
            'rekam_medis_id' => 'required|exists:rekam_medis,id',
            'obat_id' => 'required|exists:obats,id',
            'dosis' => 'required|string',
            'frekuensi' => 'required|string',
            'durasi' => 'required|string',
        ]);

        $obat = PemberianObat::create($validated);

        return response()->json([
            'message' => 'Obat berhasil ditambahkan',
            'data' => $obat->load('obat')
        ]);
    }

    public function getByRekamMedis($rekam_medis_id)
    {
        $data = PemberianObat::with(['obat', 'rekamMedis.pasien.user', 'rekamMedis.petugas'])
            ->whereHas('rekamMedis', function ($q) use ($rekam_medis_id) {
                $q->where('pasien_id', $rekam_medis_id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($data);
    }

    public function getAll()
    {
        $data = Obat::orderBy('nama_obat')->get();
        return response()->json($data);
    }
}
