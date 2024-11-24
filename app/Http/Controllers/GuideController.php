<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama_pembuat' => 'required|string|max:255',
            'tag' => 'required|string|max:25',
        ]);

        // Upload gambar
        $path = $request->file('gambar')->store('gambars', 'public');

        // Simpan data ke database
        $guide = new Guide();
        $guide->judul = $request->judul;
        $guide->isi = $request->isi;
        $guide->gambar = $path; // Simpan path gambar
        $guide->nama_pembuat = $request->nama_pembuat;
        $guide->tag = $request->tag;
        $guide->save();

        return response()->json($guide);
    }

    public function show(string $id)
    {
        $guide = Guide::find($id);
        if (!$guide) {
            return response()->json(['message' => 'Guide not found'], 404);
        }
        $guide->gambar = url('storage/' . $guide->gambar); // Menggabungkan base URL dengan path gambar
        return response()->json($guide);
    }

    public function update(Request $request, string $id)
    {
        $guide = Guide::find($id);
        
        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama_pembuat' => 'required|string|max:255',
            'tag' => 'required|string|max:25',
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($guide->gambar && Storage::disk('public')->exists($guide->gambar)) {
                Storage::disk('public')->delete($guide->gambar);
            }
            
            // Upload gambar baru
            $path = $request->file('gambar')->store('uploads/guides', 'public');
            $guide->gambar = $path; // Update path gambar
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
}
