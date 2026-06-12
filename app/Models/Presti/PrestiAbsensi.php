<?php

namespace App\Models\Presti;

use Illuminate\Database\Eloquent\Model;

class PrestiAbsensi extends Model
{
    protected $table = 'presti_absensi';

    protected $fillable = [
        'siswa_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'status',
        'catatan',
        'bukti_foto',
    ];

    public function siswa()
    {
        return $this->belongsTo(PrestiSiswa::class, 'siswa_id');
    }
}
