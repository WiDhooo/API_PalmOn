<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    // Tentukan nama tabel jika berbeda dari nama model yang diharapkan
    protected $table = 'kalkulasis';

    // Tentukan atribut yang dapat diisi secara massal
    protected $fillable = [
        'judul',
        'isi',
        'gambar',
        'nama',
    ];
}
