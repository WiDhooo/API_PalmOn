<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use Illuminate\Support\Facades\Validator;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $artikel = Artikel::get();
        return response()->json($artikel);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'nama' => 'required|string|max:100',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Handle file upload if present
        $fileName = null;
        if ($request->hasFile('gambar')) {
            $fileName = 'artikel-' . uniqid() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('assets/img'), $fileName);
        }

        // Create a new article record
        $artikel = Artikel::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'gambar' => $fileName ? 'assets/img/' . $fileName : null,
            'nama' => $request->nama,
        ]);

        return response()->json(['message' => 'Artikel created successfully', 'data' => $artikel], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $artikel = Artikel::find($id);

        if (!$artikel) {
            return response()->json(['message' => 'Artikel not found'], 404);
        }

        return response()->json($artikel);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'judul' => 'sometimes|required|string|max:255',
            'isi' => 'sometimes|required|string',
            'gambar' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'nama' => 'sometimes|required|string|max:100',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Find the article
        $artikel = Artikel::find($id);

        if (!$artikel) {
            return response()->json(['message' => 'Artikel not found'], 404);
        }

        // Handle file upload if present
        if ($request->hasFile('gambar')) {
            $fileName = 'artikel-' . uniqid() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('assets/img'), $fileName);
            $artikel->gambar = 'assets/img/' . $fileName;
        }

        // Update the article with validated data
        $artikel->update($request->only('judul', 'isi', 'nama'));

        return response()->json(['message' => 'Artikel updated successfully', 'data' => $artikel]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $artikel = Artikel::find($id);

        if (!$artikel) {
            return response()->json(['message' => 'Artikel not found'], 404);
        }

        $artikel->delete();

        return response()->json(['message' => 'Artikel deleted successfully']);
    }
}
