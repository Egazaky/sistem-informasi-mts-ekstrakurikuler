<?php

namespace App\Models\Presti;

use Illuminate\Database\Eloquent\Model;

class PrestiTagihan extends Model
{
    protected $table = 'presti_tagihan';

    protected $fillable = [
        'siswa_id',
        'nama_tagihan',
        'jenis_pembayaran',
        'nominal',
        'status',
        'tenggat_bayar',
        'tanggal_bayar',
        'bukti_bayar',
        'metode_bayar',
        'notifikasi_terkirim',
    ];

    public function siswa()
    {
        return $this->belongsTo(PrestiSiswa::class, 'siswa_id');
    }
}
