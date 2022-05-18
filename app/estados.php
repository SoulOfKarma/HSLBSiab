<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class estados extends Model
{
    protected $fillable = [
        'descripcionEstado',
    ];

    protected $table = 'estados';
}
