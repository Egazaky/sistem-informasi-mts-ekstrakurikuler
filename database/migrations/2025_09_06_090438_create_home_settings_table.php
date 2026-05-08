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
        Schema::create('home_settings', function (Blueprint $table) {
            $table->id();
            $table->string('judul_utama')->nullable();
            $table->string('subjudul_utama')->nullable();
            $table->text('mengapa_pilih_kami')->nullable();
            $table->string('akreditasi')->nullable();
            $table->text('deskripsi_akreditasi')->nullable();
            $table->text('fasilitas')->nullable(); // JSON: ["Laboratorium Komputer", "Perpustakaan Besar"]
            $table->text('alumni_sukses')->nullable();
            $table->text('sambutan_kepala_sekolah')->nullable();
            $table->string('foto_kepala_sekolah')->nullable();
            $table->text('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->text('footer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_settings');
    }
};
