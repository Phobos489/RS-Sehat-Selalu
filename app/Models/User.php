<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang bisa diisi mass assignment.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
        'role',
    ];

    /**
     * Kolom yang disembunyikan saat serialisasi.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Konversi tipe data otomatis.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Getter untuk avatar — jika tidak ada, gunakan gambar default.
     */
    public function getAvatarAttribute($value)
    {
        return $value ?: 'https://ui-avatars.com/api/?name=' . urlencode($this->name);
    }
}