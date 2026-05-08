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
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('tagline')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('registration_barcode')->nullable();
            $table->text('google_maps_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['tagline', 'whatsapp_number', 'registration_barcode', 'google_maps_link']);
        });
    }
};