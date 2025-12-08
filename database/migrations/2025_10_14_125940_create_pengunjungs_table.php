<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengunjungs', function (Blueprint $table) {
            $table->id();
            
            // Data Diri Umum
            $table->string('nama')->nullable(); // Bisa null jika corporate pakai nama_pic
            $table->string('no_identitas')->nullable();
            $table->string('no_telp')->nullable(); // Tambahan penting!
            $table->string('jenis_tamu'); // 'individu' atau 'corporate'
            
            // Data Booking
            $table->date('check_in')->nullable();
            $table->date('check_out')->nullable();
            $table->tinyInteger('checked_out')->default(0); //check out dari admin
            $table->string('kode_kamar')->nullable(); // Diganti dari 'nomor_kamar' agar cocok dengan controller
            $table->integer('jumlah_peserta')->default(1);
            $table->integer('jumlah_kamar')->default(1);
            $table->text('special_request')->nullable();
            
            // Field Khusus Corporate
            $table->string('asal_persyarikatan')->nullable();
            $table->date('tanggal_persyarikatan')->nullable(); // Tambahan penting!
            $table->string('nama_kegiatan')->nullable();
            $table->string('nama_pic')->nullable();
            $table->string('no_telp_pic')->nullable();
            
            // File Uploads & Status
            $table->string('bukti_identitas')->nullable(); // Tambahan penting!
            $table->string('bukti_pembayaran')->nullable(); // Tambahan penting!
            $table->string('payment_status')->default('pending'); // Tambahan penting!
            $table->string('metode_pembayaran')->nullable(); // Tambahan untuk Cash/ATM
            $table->decimal('total_harga', 15, 2)->nullable(); // Tambahan untuk Admin
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengunjungs');
    }
};