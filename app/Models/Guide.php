<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    //
    protected $table = 'guides';

    protected $fillable = ['judul', 'isi', 'gambar', 'nama_pembuat', 'tag'];

}
