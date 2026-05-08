<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EkstraModel extends Model
{
    use HasFactory;
    protected $table = 'ekstra';
    protected $fillable = ['nama_ekstra','deskripsi','bakat','kategori','objek_pilihan','jadwal_hari','jadwal_jam','nm_guru','gambar','is_active'];
}
