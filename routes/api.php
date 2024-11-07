<?php

use App\Http\Controllers\KalkulasiController;
use App\Http\Controllers\ArtikelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('kalkulasi', KalkulasiController::class);
Route::apiResource('artikel', ArtikelController::class);
