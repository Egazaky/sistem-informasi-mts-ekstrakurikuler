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
        Schema::table('ekstra', function (Blueprint $table) {
            $table->enum('kategori', ['minat','bakat'])->nullable()->after('bakat');
            $table->string('objek_pilihan')->nullable()->after('kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ekstra', function (Blueprint $table) {
            $table->dropColumn('kategori');
            $table->dropColumn('objek_pilihan');
        });
    }
};
