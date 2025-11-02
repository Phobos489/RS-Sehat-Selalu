<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Loket;
use App\Models\Antrian;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class PetugasLoket extends Component
{
    public $loket_id;
    public $lokets;
    public $menunggu = [];
    public $dipanggil = [];
    public $errorMessage = '';
    public $autoRefresh = true;
    public $refreshInterval = 5000; // 5 detik

    public function mount()
    {
        $this->lokets = Loket::all();
        
        // Load initial data jika loket sudah dipilih
        if ($this->loket_id) {
            $this->loadAntrian();
        }
    }

    public function updatedLoketId($value)
    {
        if ($value) {
            $this->loadAntrian();
        } else {
            $this->menunggu = [];
            $this->dipanggil = [];
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

    // Method untuk manual refresh
    public function refreshData()
    {
        $this->loadAntrian();
        $this->dispatch('antrian-refreshed'); // Dispatch event untuk JavaScript
    }

    // Method yang akan dipanggil secara otomatis
    #[On('refresh-antrian')]
    public function handleAutoRefresh()
    {
        if ($this->autoRefresh && $this->loket_id) {
            $this->loadAntrian();
        }
    }

    // Toggle auto refresh
    public function toggleAutoRefresh()
    {
        $this->autoRefresh = !$this->autoRefresh;
        
        if ($this->autoRefresh) {
            $this->dispatch('start-auto-refresh');
        } else {
            $this->dispatch('stop-auto-refresh');
        }
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
            ->layout('components.layouts.app', [
                'title' => 'Halaman Petugas Loket'
            ]);
    }
}