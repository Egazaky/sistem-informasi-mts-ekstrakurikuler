<?php

namespace App\Models;

use App\Models\KriteriaModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PertanyaanModel extends Model
{
    use HasFactory;
    protected $table = 'pertanyaan';
    protected $fillable = ['pertanyaan','kriteria_id','kategori_soal','is_active'];

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(KriteriaModel::class, 'kriteria_id');
    }
}
