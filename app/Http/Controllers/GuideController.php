<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuideController extends Controller
{
    public function index()
    {
        $guide = Guide::get();
        return response()->json($guide);
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Gambar nullable
            'nama_pembuat' => 'required|string|max:255',
            'tag' => 'required|string|max:25',
        ]);

        // Jika gambar ada, upload gambar dengan nama unik
        $fileName = null;
        if ($request->hasFile('gambar')) {
            $fileName = 'guide-' . uniqid() . '.' . $request->gambar->extension(); // Menggunakan nama unik
            $request->gambar->move(public_path('assets/img'), $fileName); // Menyimpan gambar di folder 'assets/img'
        }

        // Simpan data ke database
        $guide = new Guide();
        $guide->judul = $request->judul;
        $guide->isi = $request->isi;
        $guide->gambar = $fileName ? 'assets/img/' . $fileName : null; // Jika gambar ada, simpan path, jika tidak simpan null
        $guide->nama_pembuat = $request->nama_pembuat;
        $guide->tag = $request->tag;
        $guide->save();

        return response()->json($guide, 201);
    }

    public function show(string $id)
    {
        $guide = Guide::find($id);
        return response()->json($guide);
    }

    public function update(Request $request, string $id)
    {
        $guide = Guide::find($id);
        
        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama_pembuat' => 'required|string|max:255',
            'tag' => 'required|string|max:25',
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($guide->gambar && Storage::disk('public')->exists($guide->gambar)) {
                Storage::disk('public')->delete($guide->gambar);
            }
            
            // Upload gambar baru dengan nama unik
            $fileName = 'guide-' . uniqid() . '.' . $request->gambar->extension(); // Nama unik
            $request->gambar->move(public_path('assets/img'), $fileName); // Simpan gambar baru

            // Update path gambar
            $guide->gambar = 'assets/img/' . $fileName;
        }

        $guide->judul = $request->judul;
        $guide->isi = $request->isi;
        $guide->nama_pembuat = $request->nama_pembuat;
        $guide->tag = $request->tag;
        $guide->save();

        return response()->json($guide);
    }


    public function destroy(string $id)
    {
        $guide = Guide::find($id);
        
        // Hapus gambar jika ada
        if ($guide->gambar && Storage::disk('public')->exists($guide->gambar)) {
            Storage::disk('public')->delete($guide->gambar);
        }

        $guide->delete();
        return response()->json("Deleted");
    }

    public function tag(string $tag)
    {
        $guide = Guide::whereRaw('LOWER(tag) = ?', [strtolower($tag)])->get();

        // Cek jika tidak ada data yang ditemukan
        if ($guide->isEmpty()) {
            return response()->json(['message' => 'No guides found for this tag'], 404);
        }

        // Mengubah path gambar menjadi URL lengkap
        foreach ($guide as $item) {
            $item->gambar = url($item->gambar);  // Menambahkan domain ke path gambar
        }

        return response()->json($guide);
    }



    public function search(Request $request)
    {
        // Validate the query parameter
        $query = $request->input('query');
        if (!$query) {
            return response()->json([
                'error' => 'Query parameter is required.',
            ], 400);
        }

        // Search guides by title
        $guides = Guide::where('judul', 'LIKE', '%' . $query . '%')->get();

        // Return results
        return response()->json($guides);
    }

}
