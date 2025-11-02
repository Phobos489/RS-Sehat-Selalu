<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class GoogleAuthController extends Controller
{
    // Redirect ke halaman login Google
    public function redirectToGoogle()
    {
        // Tambahkan force prompt agar selalu bisa memilih akun
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    // Callback dari Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cek apakah user sudah ada berdasarkan google_id atau email
            $user = User::where('google_id', $googleUser->getId())
                        ->orWhere('email', $googleUser->getEmail())
                        ->first();

            if (!$user) {
                // Buat user baru jika belum ada
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => bcrypt(uniqid()), // random
                    'role' => 'petugas', // default petugas
                ]);
            } else {
                // Update data Google jika user lama login lagi
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
            }

            Auth::login($user);

            // Redirect ke intended URL atau ke halaman petugas
            return redirect()->intended('/petugas-loket');

        } catch (\Exception $e) {
            return redirect('/admin')->with('error', 'Gagal login dengan Google!');
        }
    }

    // Logout
    public function logout()
    {
        // Logout dari sesi Laravel
        Auth::logout();

        // Hapus semua sesi Laravel
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        // Kembali ke halaman utama (welcome)
        return redirect('/admin')->with('success', 'Berhasil logout.');
    }
}