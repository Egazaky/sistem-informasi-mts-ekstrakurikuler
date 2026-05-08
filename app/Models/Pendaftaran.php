<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lengkap',
        'nama_panggilan',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'alamat',
        'no_hp',
        'email',
        'nama_ayah',
        'nama_ibu',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
        'asal_sekolah',
        'dokumen_path',
        'status',
        'tahun_ajaran',
        'catatan'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function getJenisKelaminAttribute($value)
    {
        return $value === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    public function getStatusAttribute($value)
    {
        $statuses = [
            'pending' => 'Menunggu',
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak'
        ];
        return $statuses[$value] ?? $value;
    }
}
