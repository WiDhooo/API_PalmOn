<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json(Order::all());
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
            'produk_id' => 'required|exists:produks,id',
            'tanggal_order' => 'required|date',
            'total_harga' => 'required|numeric',
            'jumlah_pembelian' => 'required|integer'
        ]);

        $order = Order::create($validated);
        return response()->json($order, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
        return response()->json($order);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
        $validated = $request->validate([
            'produk_id' => 'exists:produks,id',
            'tanggal_order' => 'date',
            'total_harga' => 'numeric',
            'jumlah_pembelian' => 'integer'
        ]);

        $order->update($validated);
        return response()->json($order);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
        $order->delete();
        return response()->json(null, 204);
    }
}
