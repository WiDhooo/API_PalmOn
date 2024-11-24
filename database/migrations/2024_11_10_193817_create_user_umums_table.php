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
        Schema::create('user_umums', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50);
            $table->string('email')->unique();
            $table->string('no_telp', 15);
            $table->string('alamat', 500);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_umums');
    }
};
