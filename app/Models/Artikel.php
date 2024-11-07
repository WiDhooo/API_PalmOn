<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artikel extends Model
{
    use HasFactory;
    // Tentukan nama tabel jika berbeda dari nama model yang diharapkan
    protected $table = 'Artikels';

    // Tentukan atribut yang dapat diisi secara massal
    protected $fillable = [
        'judul',
        'isi',
        'gambar',
        'nama',
    ];
}
