<?php

namespace App\Models;

use App\Models\EkstraModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiswaekstraModel extends Model
{
    use HasFactory;
    protected $table = 'siswa_ekstra';
    protected $fillable = ['id','ekstra_id', 'siswa_id'];

    public function ekstra(): BelongsTo
    {
        return $this->belongsTo(EkstraModel::class, 'ekstra_id');
    }

}
