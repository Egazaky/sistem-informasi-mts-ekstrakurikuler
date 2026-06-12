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
        Schema::create('presti_tagihan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('presti_siswa')->onDelete('cascade');
            $table->string('nama_tagihan', 150);
            $table->enum('jenis_pembayaran', ['Syariah', 'Jariyah Gedung', 'LKM dan Daftar Ulang', 'Lain-lain']);
            $table->integer('nominal');
            $table->enum('status', ['Belum Bayar', 'Menunggu Verifikasi', 'Lunas'])->default('Belum Bayar');
            $table->date('tenggat_bayar');
            $table->datetime('tanggal_bayar')->nullable();
            $table->string('bukti_bayar', 255)->nullable();
            $table->enum('metode_bayar', ['Cash', 'Transfer'])->nullable();
            $table->boolean('notifikasi_terkirim')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presti_tagihan');
    }
};
