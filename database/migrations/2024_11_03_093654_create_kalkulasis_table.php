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
        Schema::create('kalkulasis', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->date('tgl_panen');
            $table->decimal('harga_tbs', 10, 2);
            $table->decimal('berat_total_tbs', 10, 2);
            $table->decimal('potongan_timbangan', 10, 2);
            $table->decimal('upah_panen', 10, 2);
            $table->decimal('biaya_transportasi', 10, 2);
            $table->decimal('biaya_lainnya', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kalkulasis');
    }
};
