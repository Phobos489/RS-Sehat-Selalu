<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    use HasFactory;
    
    protected $fillable = ['loket_id', 'nomor_antrian', 'status', 'waktu_panggil'];

    // Tambahkan casting untuk waktu_panggil
    protected $casts = [
        'waktu_panggil' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function loket()
    {
        return $this->belongsTo(Loket::class);
    }
}