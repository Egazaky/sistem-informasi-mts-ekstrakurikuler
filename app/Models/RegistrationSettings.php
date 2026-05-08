<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationSettings extends Model
{
    use HasFactory;

    protected $table = 'registration_settings';

    protected $fillable = [
        'judul_hero',
        'subjudul_hero',
        'tahun_ajaran',
        'badge_hero',
        'syarat_pendaftaran',
        'catatan_syarat_pendaftaran',
        'info_pendaftaran',
        'judul_gelombang_1',
        'tanggal_gelombang_1',
        'judul_gelombang_2',
        'tanggal_gelombang_2',
        'nama_lokasi',
        'alamat_lokasi',
        'catatan_lokasi',
        'program_unggulan',
        'program_unggulan_images',
        'aspek_strategis',
        'aspek_strategis_images',
        'deskripsi_ekstrakurikuler',
        'daftar_ekstrakurikuler',
        'daftar_ekstrakurikuler_images',
        'narahubung',
        'link_pendaftaran',
        'judul_slogan',
        'subjudul_slogan',
    ];

    protected $casts = [
        'syarat_pendaftaran' => 'array',
        'program_unggulan' => 'array',
        'aspek_strategis' => 'array',
        'daftar_ekstrakurikuler' => 'array',
        'narahubung' => 'array',
    ];
}
