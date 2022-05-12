<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class autorizadoretiros extends Model
{
    protected $fillable = [
        'RUN', 'NOMBRES','APELLIDOS', 'FECINI', 'FECFIN', 'ESTADO',
        'idEstado','idServicio',
       
    ];

    protected $table = 'autorizadoretiro';
}
