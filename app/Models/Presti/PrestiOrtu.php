<?php

namespace App\Models\Presti;

use Illuminate\Database\Eloquent\Model;

class PrestiOrtu extends Model
{
    protected $table = 'presti_ortu';

    protected $fillable = [
        'siswa_id',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function siswa()
    {
        return $this->belongsTo(PrestiSiswa::class, 'siswa_id');
    }
}
