<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'hero_year',
        'hero_badge',
        'requirements',
        'requirements_note',
        'registration_info',
        'wave1_title',
        'wave1_date',
        'wave2_title',
        'wave2_date',
        'location_name',
        'location_address',
        'location_note',
        'featured_programs',
        'strategic_aspects',
        'extracurricular_description',
        'extracurricular_list',
        'contact_persons',
        'registration_link',
        'qr_code_image',
        'slogan_title',
        'slogan_subtitle',
    ];

    protected $casts = [
        'requirements' => 'array',
        'featured_programs' => 'array',
        'strategic_aspects' => 'array',
        'extracurricular_list' => 'array',
        'contact_persons' => 'array',
    ];

    public static function getContent()
    {
        $content = self::first();

        if (!$content) {
            // Create default content if none exists
            $content = self::create([
                'requirements' => [
                    'Mengisi Formulir Pendaftaran',
                    'Fotokopi Akta Kelahiran',
                    'Fotokopi Kartu Keluarga',
                    'Fotokopi KIP/PKH/KKS (jika ada)',
                    'Fotokopi Surat Keterangan lulus/ijazah'
                ],
                'featured_programs' => [
                    [
                        'title' => 'Bahsul Kutub ala Madrasah Diniyah',
                        'description' => 'Program pembelajaran kitab kuning dengan metode diskusi dan analisis mendalam sesuai tradisi pesantren salaf.',
                        'icon' => 'bi-book',
                        'color' => 'primary'
                    ],
                    [
                        'title' => 'Tahsin dan Tahfidz Qur\'an',
                        'description' => 'Program perbaikan bacaan dan hafalan Al-Qur\'an dengan metode yang sistematis dan terstruktur.',
                        'icon' => 'bi-book-half',
                        'color' => 'success'
                    ]
                ],
                'strategic_aspects' => [
                    [
                        'title' => 'Pondok Pesantren Darussalam',
                        'description' => 'Tersedia Pondok Pesantren Darussalam (Kitab Salaf) untuk pembelajaran kitab kuning dan tradisi pesantren.',
                        'icon' => 'bi-building',
                        'color' => 'primary'
                    ],
                    [
                        'title' => 'Pondok Pesantren Al-Lubab',
                        'description' => 'Tersedia Pondok Pesantren Al-Lubab (Qur\'an) untuk program tahsin dan tahfidz Al-Qur\'an.',
                        'icon' => 'bi-house',
                        'color' => 'success'
                    ]
                ],
                'extracurricular_list' => [
                    ['name' => 'Futsal', 'icon' => 'bi-soccer', 'color' => 'primary'],
                    ['name' => 'Pramuka', 'icon' => 'bi-compass', 'color' => 'success'],
                    ['name' => 'Menjahit', 'icon' => 'bi-scissors', 'color' => 'warning'],
                    ['name' => 'Jurnalistik', 'icon' => 'bi-newspaper', 'color' => 'info'],
                    ['name' => 'Sablon', 'icon' => 'bi-palette', 'color' => 'danger'],
                    ['name' => 'Rebbana', 'icon' => 'bi-music-note', 'color' => 'purple']
                ],
                'contact_persons' => [
                    ['name' => 'Bapak M. Miftahul Huda', 'phone' => '087815397582'],
                    ['name' => 'Bapak Wahid Hidayanto', 'phone' => '081325677579'],
                    ['name' => 'Bapak M. Yusron Isro\'i', 'phone' => '085640010405']
                ]
            ]);
        }

        return $content;
    }
}
