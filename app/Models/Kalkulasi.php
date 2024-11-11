<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kalkulasi extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari nama model yang diharapkan
    protected $table = 'kalkulasis';

    // Tentukan atribut yang dapat diisi secara massal
    protected $fillable = [
        'id_user',
        'tgl_panen',
        'harga_tbs',
        'berat_total_tbs',
        'potongan_timbangan',
        'upah_panen',
        'biaya_transportasi',
        'biaya_lainnya',
    ];
}
