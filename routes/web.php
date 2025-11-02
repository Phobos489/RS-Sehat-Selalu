<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\PetugasLoket;
use App\Livewire\DisplayAntrian;
use App\Http\Controllers\Auth\GoogleAuthController;

Route::get('/admin', function () {
    return view('welcome');
});

// Route untuk redirect ke Google login (sebagai fallback)
Route::get('/login', function () {
    return redirect('/auth/google');
})->name('login');

// Route authentication Google
Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);
Route::get('logout', [GoogleAuthController::class, 'logout'])->name('logout');

// Route untuk petugas loket - pastikan menggunakan middleware auth
Route::middleware(['auth'])->group(function () {
    Route::get('/petugas-loket', PetugasLoket::class)->name('petugas.loket');
});

// Route untuk display antrian (tanpa login)
Route::get('/', DisplayAntrian::class)->name('display.antrian');