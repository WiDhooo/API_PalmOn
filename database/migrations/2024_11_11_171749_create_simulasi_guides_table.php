<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('simulasi_guides', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kebun');
            $table->string('lokasi');
            $table->float('luas_kebun');
            $table->integer('jumlah_pohon');
            $table->string('jenis_bibit');
            $table->string('jenis_tanah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simulasi_guides');
    }
};
