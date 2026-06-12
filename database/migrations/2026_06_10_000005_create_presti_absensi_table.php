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
        Schema::create('presti_absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->nullable()->constrained('presti_siswa')->onDelete('set null');
            $table->date('tanggal')->nullable();
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->enum('status', ['Hadir', 'Terlambat', 'Sakit', 'Izin', 'Alpha'])->nullable();
            $table->text('catatan')->nullable();
            $table->string('bukti_foto', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presti_absensi');
    }
};
