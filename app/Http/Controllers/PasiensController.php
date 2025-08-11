<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasiensController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pasiens = Pasien::with('user')->get();
        return view('dashboard.pages.pasien', compact('pasiens'));
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
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|min:6',
            'nik'            => 'required|string|max:20|unique:pasiens,nik',
            'tanggal_lahir'  => 'required|date',
            'alamat'         => 'required|string',
            'jenis_kelamin'  => 'required|in:L,P',
        ]);

        // Buat user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'pasien',
        ]);

        // Buat pasien
        Pasien::create([
            'user_id'       => $user->id,
            'nik'           => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat'        => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        return redirect()->route('pasien.index')->with('success', 'Pasien berhasil ditambahkan');
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
        $pasien = Pasien::with('user')->findOrFail($id);

        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email,' . $pasien->user->id,
            'password'       => 'nullable|min:6',
            'nik'            => 'required|string|max:20|unique:pasiens,nik,' . $pasien->id,
            'tanggal_lahir'  => 'required|date',
            'alamat'         => 'required|string',
            'jenis_kelamin'  => 'required|in:L,P',
        ]);

        // Update user
        $pasien->user->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->filled('password') ? Hash::make($request->password) : $pasien->user->password,
        ]);

        // Update pasien
        $pasien->update([
            'nik'           => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat'        => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        return redirect()->route('pasien.index')->with('success', 'Pasien berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pasien = Pasien::findOrFail($id);

        // simpan id user
        $userId = $pasien->user_id;

        // hapus pasien dulu
        $pasien->delete();

        // baru hapus user
        User::find($userId)?->delete();

        return redirect()->route('pasien.index')->with('success', 'Pasien berhasil dihapus');
    }
}
