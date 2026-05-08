<?php
// Model untuk menyimpan wali kelas per kelas
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaliKelas extends Model
{
    protected $table = 'wali_kelas';
    protected $fillable = ['kelas', 'nama_wali'];
    public $timestamps = false;
}
