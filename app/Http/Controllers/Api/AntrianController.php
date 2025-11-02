<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Loket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AntrianController extends Controller
{
    // GET /api/antrian/dipanggil
    public function getDipanggil()
    {
        $data = Antrian::with('loket')
            ->where('status', 'dipanggil')
            ->orderBy('waktu_panggil', 'desc')
            ->get();

        return response()->json($data);
    }

    // GET /api/antrian (untuk testing)
    public function index()
    {
        return response()->json(Antrian::with('loket')->get());
    }

    // GET /api/antrian/menunggu
    public function getMenunggu(Request $request)
    {
        $request->validate(['loket_id' => 'required|exists:lokets,id']);
        
        $data = Antrian::with('loket')
            ->where('status', 'menunggu')
            ->where('loket_id', $request->loket_id)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($data);
    }

    // POST /api/antrian/ambil
    public function ambilNomor(Request $request)
    {
        $request->validate(['loket_id' => 'required|exists:lokets,id']);

        $loket = Loket::find($request->loket_id);
        
        // Hitung antrian hari ini saja
        $jumlah = Antrian::where('loket_id', $loket->id)
            ->whereDate('created_at', today())
            ->count() + 1;

        // Solusi lebih baik untuk kode huruf
        $huruf = $this->generateHurufLoket($loket->id);
        $nomor = sprintf("%s%03d", $huruf, $jumlah);

        $antrian = Antrian::create([
            'loket_id' => $loket->id,
            'nomor_antrian' => $nomor,
            'status' => 'menunggu'
        ]);

        return response()->json($antrian, 201);
    }

    private function generateHurufLoket($id)
    {
        // Mapping ID ke huruf (A, B, C, ...)
        $huruf = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
        return $huruf[$id - 1] ?? 'X';
    }

    // PUT /api/antrian/{id}/status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,dipanggil,selesai',
        ]);

        $antrian = Antrian::findOrFail($id);

        // Jika mengubah status menjadi 'dipanggil'
        if ($request->status === 'dipanggil') {
            // Cek apakah sudah ada antrian yang sedang dipanggil di loket yang sama
            $antrianSedangDipanggil = Antrian::where('loket_id', $antrian->loket_id)
                ->where('status', 'dipanggil')
                ->where('id', '!=', $id)
                ->exists();

            if ($antrianSedangDipanggil) {
                return response()->json([
                    'error' => 'Sudah ada antrian yang sedang dipanggil di loket ini. Selesaikan terlebih dahulu.'
                ], 422);
            }

            $antrian->waktu_panggil = now();
        }

        $antrian->status = $request->status;
        $antrian->save();

        return response()->json($antrian);
    }
}