<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use Illuminate\Http\Request;

class GuideController extends Controller
{
    public function index()
    {
        //
        $guide = Guide::get();
        return response()->json($guide);
    }

    public function store(Request $request)
    {
        $guide = new Guide();
        $guide->judul=$request->judul ;
        $guide->isi=$request->isi;
        $guide->gambar=$request->gambar;
        $guide->nama_pembuat=$request->nama_pembuat;
        $guide->save();
        return response()->json();

    }
    public function show(string $id)
    {
      $guide = Guide::find($id);
      return response()->json($guide);  
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request, string $id)
    {
        $guide = Guide::find($id);
        $guide->judul=$request->judul;
        $guide->isi=$request->isi;
        $guide->gambar=$request->gambar;
        $guide->nama_pembuat=$request->nama_pembuat;
        $guide->save();
        return response()->json($guide);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Guide::destroy($id);
        return response()->json("Deleted");
    }
}
