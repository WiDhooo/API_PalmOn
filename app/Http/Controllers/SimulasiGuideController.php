<?php

namespace App\Http\Controllers;

use App\Models\SimulasiGuide;
use Illuminate\Http\Request;

class SimulasiGuideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json(SimulasiGuide::all());
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
            'nama_kebun' => 'required|string',
            'lokasi' => 'required|string',
            'luas_kebun' => 'required|numeric',
            'jumlah_pohon' => 'required|integer',
            'jenis_bibit' => 'required|string',
            'jenis_tanah' => 'required|string'
        ]);

        $simulasiGuide = SimulasiGuide::create($validated);
        return response()->json($simulasiGuide, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(SimulasiGuide $simulasiGuide)
    {
        //
        return response()->json($simulasiGuide);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SimulasiGuide $simulasiGuide)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SimulasiGuide $simulasiGuide)
    {
        //
        $validated = $request->validate([
            'nama_kebun' => 'string',
            'lokasi' => 'string',
            'luas_kebun' => 'numeric',
            'jumlah_pohon' => 'integer',
            'jenis_bibit' => 'string',
            'jenis_tanah' => 'string'
        ]);

        $simulasiGuide->update($validated);
        return response()->json($simulasiGuide);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SimulasiGuide $simulasiGuide)
    {
        //
        $simulasiGuide->delete();
        return response()->json(null, 204);
    }
}
