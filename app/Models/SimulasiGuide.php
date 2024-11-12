<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SimulasiGuide extends Model
{
    //
    protected $table = 'simulasi_guides';
    protected $fillable = [
        'nama_kebun',
        'lokasi',
        'luas_kebun',
        'jumlah_pohon',
        'jenis_bibit',
        'jenis_tanah'
    ];
}
