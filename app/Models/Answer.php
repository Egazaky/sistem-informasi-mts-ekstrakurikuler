<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'question_id',
        'kategori',
        'value',
    ];

    public function siswa()
    {
        return $this->belongsTo(\App\Models\SiswaModel::class, 'user_id');
    }
}
