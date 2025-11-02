<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Antrian;

class DisplayAntrian extends Component
{
    public $antrianDipanggil = [];

    public function mount()
    {
        $this->loadAntrianDipanggil();
    }

    public function loadAntrianDipanggil()
    {
        $this->antrianDipanggil = Antrian::with('loket')
            ->where('status', 'dipanggil')
            ->orderBy('waktu_panggil', 'desc')
            ->get();
    }

    public function render()
    {
        // Auto refresh setiap 3 detik
        $this->loadAntrianDipanggil();
        
        return view('livewire.display-antrian')
            ->layout('components.layouts.display', [
                'title' => 'Display Antrian - RS Sehat Selalu'
            ]);
    }
}