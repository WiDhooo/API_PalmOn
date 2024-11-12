<?php

//API DISINI SEMUA
use App\Http\Controllers\KalkulasiController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\UserUmumController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\SimulasiGuideController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\OrderController;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Menampilkan semua kalkulasi berdasarkan id_user
Route::get('kalkulasi/{id_user}', [KalkulasiController::class, 'index']);

// Menambah kalkulasi baru berdasarkan id_user
Route::post('kalkulasi/{id_user}', [KalkulasiController::class, 'store']);

// Menampilkan kalkulasi berdasarkan id_user dan id
Route::get('kalkulasi/{id_user}/{id}', [KalkulasiController::class, 'show']);

// Mengupdate kalkulasi berdasarkan id_user dan id
Route::put('kalkulasi/{id_user}/{id}', [KalkulasiController::class, 'update']);

// Menghapus kalkulasi berdasarkan id_user dan id
Route::delete('kalkulasi/{id_user}/{id}', [KalkulasiController::class, 'destroy']);
Route::apiResource('artikel', ArtikelController::class);
Route::apiResource('user_umum', UserUmumController::class);
Route::post('user_umum/login', [UserUmumController::class, 'login']);

Route::apiResource("guides", GuideController::class);
Route::apiResource('simulasi_guides', SimulasiGuideController::class);
Route::apiResource('produks', ProdukController::class);
Route::apiResource('orders', OrderController::class);