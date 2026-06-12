<?php

namespace App\Models\Presti;

use Illuminate\Database\Eloquent\Model;

class PrestiAdmin extends Model
{
    protected $table = 'presti_admin';

    protected $fillable = [
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
