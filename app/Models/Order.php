<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $table = 'orders';
    protected $fillable = [
        'produk_id',
        'tanggal_order',
        'total_harga',
        'jumlah_pembelian'
    ];
}
