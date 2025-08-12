<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\PemberianObat;
use App\Models\RekamMedis;
use App\Models\Rujukan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $rekamMedis = RekamMedis::count();
        $pemberianObat = PemberianObat::count();
        $rujukan = Rujukan::count();
        $pasiens = Pasien::count();
        return view('dashboard.pages.index', compact('rekamMedis', 'pemberianObat', 'rujukan', 'pasiens'));
    }
}
