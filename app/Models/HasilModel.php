<?php

namespace App\Models;

use App\Models\EkstraModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HasilModel extends Model
{
    use HasFactory;
    protected $table = 'hasil';
    protected $fillable = ['ekstra_id','total','metode'];

    public function ekstra(): BelongsTo
    {
        return $this->belongsTo(EkstraModel::class, 'ekstra_id');
    }
}
