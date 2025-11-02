<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Loket;

class LoketSeeder extends Seeder
{
    public function run(): void
    {
        $lokets = [
            ['nama_loket' => 'Pendaftaran Umum', 'deskripsi' => 'Loket untuk pendaftaran pasien umum.'],
            ['nama_loket' => 'Poli Gigi', 'deskripsi' => 'Loket untuk pasien pemeriksaan gigi.'],
            ['nama_loket' => 'Farmasi', 'deskripsi' => 'Loket untuk pengambilan obat.'],
        ];

        foreach ($lokets as $loket) {
            Loket::create($loket);
        }
    }
}
