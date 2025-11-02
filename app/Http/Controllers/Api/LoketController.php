<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Loket;
use Illuminate\Http\Request;

class LoketController extends Controller
{
    // GET /api/lokets
    public function index()
    {
        return response()->json(Loket::all());
    }

    // POST /api/lokets
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_loket' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $loket = Loket::create($validated);
        return response()->json($loket, 201);
    }

    // GET /api/lokets/{id}
    public function show($id)
    {
        $loket = Loket::findOrFail($id);
        return response()->json($loket);
    }

    // PUT /api/lokets/{id}
    public function update(Request $request, $id)
    {
        $loket = Loket::findOrFail($id);
        $loket->update($request->only(['nama_loket', 'deskripsi']));
        return response()->json($loket);
    }

    // DELETE /api/lokets/{id}
    public function destroy($id)
    {
        $loket = Loket::findOrFail($id);
        $loket->delete();
        return response()->json(['message' => 'Loket deleted successfully']);
    }
}