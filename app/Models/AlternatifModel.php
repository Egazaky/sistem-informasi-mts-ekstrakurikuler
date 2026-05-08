<?php

namespace App\Models;

use App\Models\EkstraModel;
use App\Models\KriteriaModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AlternatifModel extends Model
{
    use HasFactory;
    protected $table = 'alternatif';
    protected $fillable = ['ekstra_id','kriteria_id','nilai'];

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(KriteriaModel::class, 'kriteria_id');
    }

    public function ekstra(): BelongsTo
    {
        return $this->belongsTo(EkstraModel::class, 'ekstra_id');
    }
}
