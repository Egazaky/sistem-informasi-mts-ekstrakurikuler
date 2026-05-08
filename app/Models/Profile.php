<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'whatsapp_link',
        'kepala_sekolah_nama',
        'kepala_sekolah_sambutan',
        'kepala_sekolah_foto',
        'about_title',
        'about_description',
        'about_image',
        'tagline',
        'whatsapp_number',
        'registration_barcode',
        'google_maps_link',
    ];
}