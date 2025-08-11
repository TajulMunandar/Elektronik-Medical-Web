<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PasiensController;
use App\Http\Controllers\PemberianObatController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\RujukanController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard.pages.index');
})->middleware('auth');

Route::get('/login', function () {
    return view('auth.signup');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/auth', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('sign-in');
});

Route::resource('obat', ObatController::class)->middleware('auth');
Route::resource('user', UsersController::class)->middleware('auth');
Route::resource('pasien', PasiensController::class)->middleware('auth');
Route::resource('rekam-medis', RekamMedisController::class)->middleware('auth');
Route::resource('pemberian-obat', PemberianObatController::class)->middleware('auth');
Route::resource('rujukan', RujukanController::class)->middleware('auth');
