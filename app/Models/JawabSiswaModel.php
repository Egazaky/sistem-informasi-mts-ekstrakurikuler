<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabSiswaModel extends Model
{
    use HasFactory;
    protected $table = 'jawab_siswa';
    protected $fillable = ['siswa_id','pertanyaan_id','ekstra_id', 'nilai'];
}
