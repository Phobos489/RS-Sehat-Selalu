<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Loket;
use App\Models\Antrian;

class AmbilAntrian extends Component
{
    public $lokets;
    public $selectedLoketId;
    public $antrianTerakhir;
    public $message = '';
    public $error = '';

    public function mount()
    {
        $this->lokets = Loket::all();
    }

    public function ambilAntrian()
    {
        $this->reset(['message', 'error']);

        if (!$this->selectedLoketId) {
            $this->error = 'Silakan pilih loket terlebih dahulu.';
            return;
        }

        try {
            $loket = Loket::findOrFail($this->selectedLoketId);
            
            // Hitung antrian hari ini saja
            $jumlah = Antrian::where('loket_id', $loket->id)
                ->whereDate('created_at', today())
                ->count() + 1;

            // Generate kode huruf berdasarkan loket
            $huruf = $this->generateHurufLoket($loket->id);
            $nomor = sprintf("%s%03d", $huruf, $jumlah);

            $antrian = Antrian::create([
                'loket_id' => $loket->id,
                'nomor_antrian' => $nomor,
                'status' => 'menunggu'
            ]);

            $this->antrianTerakhir = $antrian;
            $this->message = "Nomor antrian berhasil diambil!";
            
            // Reset selected loket
            $this->selectedLoketId = null;

        } catch (\Exception $e) {
            $this->error = 'Terjadi kesalahan saat mengambil nomor antrian. Silakan coba lagi.';
        }
    }

    private function generateHurufLoket($id)
    {
        // Mapping ID ke huruf (A, B, C, ...)
        $huruf = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
        return $huruf[$id - 1] ?? 'X';
    }

    public function render()
    {
        return view('livewire.ambil-antrian')
            ->layout('components.layouts.display', [
                'title' => 'Ambil Antrian - RS Sehat Selalu'
            ]);
    }
}