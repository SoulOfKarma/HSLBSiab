<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class seguimientoMateriales extends Model
{
    protected $fillable = [
        'id_usuario','id_material','descripcion_seguimiento'
    ];
}

