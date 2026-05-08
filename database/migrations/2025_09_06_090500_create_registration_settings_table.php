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
        Schema::create('registration_settings', function (Blueprint $table) {
            $table->id();
            // Hero Section
            $table->string('judul_hero')->nullable();
            $table->string('subjudul_hero')->nullable();
            $table->string('tahun_ajaran')->nullable();
            $table->string('badge_hero')->nullable();
            // Syarat Pendaftaran
            $table->text('syarat_pendaftaran')->nullable(); // JSON
            $table->string('catatan_syarat_pendaftaran')->nullable();
            // Informasi Pendaftaran
            $table->text('info_pendaftaran')->nullable();
            $table->string('judul_gelombang_1')->nullable();
            $table->string('tanggal_gelombang_1')->nullable();
            $table->string('judul_gelombang_2')->nullable();
            $table->string('tanggal_gelombang_2')->nullable();
            // Lokasi Pendaftaran
            $table->string('nama_lokasi')->nullable();
            $table->string('alamat_lokasi')->nullable();
            $table->string('catatan_lokasi')->nullable();
            // Program & Ekstrakurikuler
            $table->text('program_unggulan')->nullable(); // JSON
            $table->text('aspek_strategis')->nullable(); // JSON
            $table->text('deskripsi_ekstrakurikuler')->nullable();
            $table->text('daftar_ekstrakurikuler')->nullable(); // JSON
            // Narahubung & Link
            $table->text('narahubung')->nullable(); // JSON
            $table->string('link_pendaftaran')->nullable();
            // Slogan
            $table->string('judul_slogan')->nullable();
            $table->string('subjudul_slogan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_settings');
    }
};
