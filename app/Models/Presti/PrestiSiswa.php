<?php

namespace App\Models\Presti;

use Illuminate\Database\Eloquent\Model;

class PrestiSiswa extends Model
{
    protected $table = 'presti_siswa';

    protected $fillable = [
        'nis',
        'password',
        'nama',
        'kelas',
        'no_hp_ortu',
    ];

    protected $hidden = [
        'password',
    ];

    public function ortu()
    {
        return $this->hasOne(PrestiOrtu::class, 'siswa_id');
    }

    public function absensi()
    {
        return $this->hasMany(PrestiAbsensi::class, 'siswa_id');
    }

    public function tagihan()
    {
        return $this->hasMany(PrestiTagihan::class, 'siswa_id');
    }
}
