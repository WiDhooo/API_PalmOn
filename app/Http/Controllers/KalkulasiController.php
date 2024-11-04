<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kalkulasi;

class KalkulasiController extends Controller
{
    public function index()
    {
        $data = Kalkulasi::all();

        $result = $data->map(function ($item) {
            $berat_bersih = $item->berat_total_tbs * (100-$item->potongan_timbangan)/100;
            $total_pendapatan = $berat_bersih * $item->harga_tbs;
            $total_pengeluaran = ($item->upah_panen * $item->berat_total_tbs) + $item->biaya_transportasi + $item->biaya_lainnya;
            $total_hasil_bersih = $total_pendapatan - $total_pengeluaran;

            return [
                'tgl_panen' => $item->tgl_panen,
                'total_hasil_bersih' => $total_hasil_bersih,
                'total_pendapatan' => $total_pendapatan,
                'total_pengeluaran' => $total_pengeluaran,
                'id' => $item->id,
            ];
        });

        return response()->json($result);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tgl_panen' => 'required|date',
            'harga_tbs' => 'required|numeric',
            'berat_total_tbs' => 'required|numeric',
            'potongan_timbangan' => 'required|numeric',
            'upah_panen' => 'required|numeric',
            'biaya_transportasi' => 'required|numeric',
            'biaya_lainnya' => 'required|numeric',
        ]);

        $record = Kalkulasi::create($validated);

        return response()->json($record, 201);
    }

    public function show($id)
    {
        $kalkulasi = Kalkulasi::find($id);

        if (!$kalkulasi) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        $berat_bersih = $kalkulasi->berat_total_tbs * (100-$kalkulasi->potongan_timbangan)/100;
        $total_pendapatan = $berat_bersih * $kalkulasi->harga_tbs;
        $total_pengeluaran = ($kalkulasi->upah_panen * $kalkulasi->berat_total_tbs) + $kalkulasi->biaya_transportasi + $kalkulasi->biaya_lainnya;
        $total_hasil_bersih = $total_pendapatan - $total_pengeluaran;

        return response()->json([
            'tgl_panen' => $kalkulasi->tgl_panen,
            'berat_total_tbs' => $kalkulasi->berat_total_tbs,
            'harga_tbs' => $kalkulasi->harga_tbs,
            'potongan_timbangan' => $kalkulasi->potongan_timbangan,
            'upah_panen' => $kalkulasi->upah_panen,
            'biaya_transportasi' => $kalkulasi->biaya_transportasi,
            'biaya_lainnya' => $kalkulasi->biaya_lainnya,
            'total_hasil_bersih' => $total_hasil_bersih,
            'total_pendapatan' => $total_pendapatan,
            'total_pengeluaran' => $total_pengeluaran,
            'berat_bersih' => $berat_bersih,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tgl_panen' => 'date',
            'harga_tbs' => 'numeric',
            'berat_total_tbs' => 'numeric',
            'potongan_timbangan' => 'numeric',
            'upah_panen' => 'numeric',
            'biaya_transportasi' => 'numeric',
            'biaya_lainnya' => 'numeric',
        ]);

        $record = Kalkulasi::findOrFail($id);
        $record->update($validated);

        return response()->json($record);
    }

    public function destroy($id)
    {
        $record = Kalkulasi::findOrFail($id);
        $record->delete();

        return response()->json(["message" => "DELETED"]);
    }
}
