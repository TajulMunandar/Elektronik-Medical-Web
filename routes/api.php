<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasiensController;
use App\Http\Controllers\PemberianObatController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\RujukanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register-pasien', [AuthController::class, 'registerPasien']);
Route::post('/login', [AuthController::class, 'login']);
// routes/api.php
Route::get('/pasiens/search', [PasiensController::class, 'search']);
Route::middleware('auth:sanctum')->get('/rekam-medis', [RekamMedisController::class, 'getData']);
Route::middleware('auth:sanctum')->get('/rekam-medis/pasien/{rekamMedisId}', [RekamMedisController::class, 'getByPasien']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/rekam-medis-data', [RekamMedisController::class, 'storeData']);
    Route::get('/rekam-medis-saya', [RekamMedisController::class, 'rekamMedisSaya']);
    Route::get('/pemberian-obat', [PemberianObatController::class, 'getData']);
    Route::get('/obats', [PemberianObatController::class, 'getAll']);
    Route::post('/pemberian-obat', [PemberianObatController::class, 'storeData']);
    Route::get('/pemberian-obats/{rekamMedisId}', [PemberianObatController::class, 'getByRekamMedis']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/rujukan', [RujukanController::class, 'getData']);
    Route::post('/rujukan', [RujukanController::class, 'storeData']);
});
