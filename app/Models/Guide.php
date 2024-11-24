<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Guide extends Model
{
    //
    use HasFactory;
    protected $table = 'guides';

    protected $fillable = ['judul', 'isi', 'gambar', 'nama_pembuat', 'tag'];

}
