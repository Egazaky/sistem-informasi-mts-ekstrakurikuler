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
        Schema::table('registration_settings', function (Blueprint $table) {
            $table->text('program_unggulan_images')->nullable()->after('program_unggulan');
            $table->text('aspek_strategis_images')->nullable()->after('aspek_strategis');
            $table->text('daftar_ekstrakurikuler_images')->nullable()->after('daftar_ekstrakurikuler');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registration_settings', function (Blueprint $table) {
            $table->dropColumn('program_unggulan_images');
            $table->dropColumn('aspek_strategis_images');
            $table->dropColumn('daftar_ekstrakurikuler_images');
        });
    }
};
