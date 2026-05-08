<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul_utama',
        'subjudul_utama',
        'mengapa_pilih_kami',
        'akreditasi',
        'deskripsi_akreditasi',
        'fasilitas',
        'alumni_sukses',
        'sambutan_kepala_sekolah',
        'foto_kepala_sekolah',
        'alamat',
        'telepon',
        'email',
        'footer'
    ];
}
