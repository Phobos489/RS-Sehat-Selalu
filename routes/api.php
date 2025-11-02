<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoketController;
use App\Http\Controllers\Api\AntrianController;

Route::apiResource('lokets', LoketController::class);

// Routes untuk antrian
Route::post('antrian/ambil', [AntrianController::class, 'ambilNomor']);
Route::put('antrian/{id}/status', [AntrianController::class, 'updateStatus']);
Route::get('antrian/dipanggil', [AntrianController::class, 'getDipanggil']);
Route::get('antrian/menunggu', [AntrianController::class, 'getMenunggu']);
Route::get('antrian', [AntrianController::class, 'index']); // Untuk testing