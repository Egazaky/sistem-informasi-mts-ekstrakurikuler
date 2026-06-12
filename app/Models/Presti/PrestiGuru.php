<?php

namespace App\Models\Presti;

use Illuminate\Database\Eloquent\Model;

class PrestiGuru extends Model
{
    protected $table = 'presti_guru';

    protected $fillable = [
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
