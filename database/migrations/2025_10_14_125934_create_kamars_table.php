<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kamars', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kamar')->unique(); // Ganti nomor_kamar jadi ini
            $table->string('jenis_kamar');
            
            // --- TAMBAHAN BARU AGAR SEEDER TIDAK ERROR ---
            $table->string('gedung')->nullable(); 
            // ---------------------------------------------
            
            $table->decimal('harga', 10, 2);
            $table->string('status')->default('kosong');
            $table->text('fasilitas')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kamars');
    }
};