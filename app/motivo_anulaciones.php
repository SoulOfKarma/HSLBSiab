<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class motivo_anulaciones extends Model
{
    protected $fillable = [
        'CODMOT','NOMMOT',       
    ];

    protected $table = 'motivo_anulacion';
}
