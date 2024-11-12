<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json(Produk::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'nama_produk' => 'required|string',
            'banyak_produk' => 'required|integer',
            'harga_produk' => 'required|numeric'
        ]);

        $produk = Produk::create($validated);
        return response()->json($produk, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        //
        return response()->json($produk);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        //
        $validated = $request->validate([
            'nama_produk' => 'string',
            'banyak_produk' => 'integer',
            'harga_produk' => 'numeric'
        ]);

        $produk->update($validated);
        return response()->json($produk);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        //
        $produk->delete();
        return response()->json(null, 204);
    }
}
