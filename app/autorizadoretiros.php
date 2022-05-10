<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class autorizadoretiros extends Model
{
    protected $fillable = [
        'RUN', 'NOMBRES','APELLIDOS', 'FECINI', 'FECFIN', 'ESTADO',
        'NOMSER','NOMARCH',
       
    ];

    protected $table = 'autorizadoretiro';
}
