<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Loket;
use App\Models\Antrian;
use Illuminate\Support\Facades\Auth;

class PetugasLoket extends Component
{
    public $loket_id;
    public $lokets;
    public $menunggu = [];
    public $dipanggil = [];
    public $errorMessage = '';

    public function mount()
    {
        $this->lokets = Loket::all();
    }

    public function updatedLoketId($value)
    {
        if ($value) {
            $this->loadAntrian();
        }
    }

    public function loadAntrian()
    {
        if ($this->loket_id) {
            $this->menunggu = Antrian::with('loket')
                ->where('loket_id', $this->loket_id)
                ->where('status', 'menunggu')
                ->orderBy('created_at', 'asc')
                ->get();

            $this->dipanggil = Antrian::with('loket')
                ->where('loket_id', $this->loket_id)
                ->where('status', 'dipanggil')
                ->orderBy('waktu_panggil', 'desc')
                ->get();
        } else {
            $this->menunggu = [];
            $this->dipanggil = [];
        }
        
        // Reset error message
        $this->errorMessage = '';
    }

    public function panggil($id)
    {
        try {
            $antrian = Antrian::findOrFail($id);
            
            // Cek apakah sudah ada antrian yang sedang dipanggil di loket yang sama
            $antrianSedangDipanggil = Antrian::where('loket_id', $this->loket_id)
                ->where('status', 'dipanggil')
                ->where('id', '!=', $id)
                ->exists();

            if ($antrianSedangDipanggil) {
                $this->errorMessage = 'Masih ada antrian yang sedang dipanggil. Selesaikan terlebih dahulu sebelum memanggil antrian baru.';
                return;
            }

            $antrian->update([
                'status' => 'dipanggil',
                'waktu_panggil' => now(),
            ]);

            $this->loadAntrian();
            session()->flash('message', 'Antrian ' . $antrian->nomor_antrian . ' berhasil dipanggil!');
            $this->errorMessage = '';

        } catch (\Exception $e) {
            $this->errorMessage = 'Terjadi kesalahan saat memanggil antrian.';
        }
    }

    public function selesai($id)
    {
        try {
            $antrian = Antrian::findOrFail($id);
            
            // Pastikan antrian yang akan diselesaikan berstatus 'dipanggil'
            if ($antrian->status !== 'dipanggil') {
                $this->errorMessage = 'Hanya antrian yang sedang dipanggil yang dapat diselesaikan.';
                return;
            }

            $antrian->update(['status' => 'selesai']);

            $this->loadAntrian();
            session()->flash('message', 'Antrian ' . $antrian->nomor_antrian . ' telah selesai!');
            $this->errorMessage = '';

        } catch (\Exception $e) {
            $this->errorMessage = 'Terjadi kesalahan saat menyelesaikan antrian.';
        }
    }

    public function render()
    {
        return view('livewire.petugas-loket')
            ->layout('components.layouts.petugas', [
                'title' => 'Halaman Petugas Loket'
            ]);
    }
}