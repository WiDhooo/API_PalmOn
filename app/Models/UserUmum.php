<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserUmum extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari nama model yang diharapkan
    protected $table = 'user_umums';

    // Tentukan atribut yang dapat diisi secara massal
    protected $fillable = [
        'nama',
        'email',
        'no_telp',
        'alamat',
    ];
}
