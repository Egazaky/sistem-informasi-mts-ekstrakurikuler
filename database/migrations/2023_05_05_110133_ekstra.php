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
        Schema::create('ekstra', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ekstra');
            $table->enum('is_active', ['0','1']);
            $table->string('deskripsi');
            $table->string('jadwal_hari');
            $table->string('jadwal_jam');
            $table->string('nm_guru');
            $table->string('gambar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ekstra');
    }
};
