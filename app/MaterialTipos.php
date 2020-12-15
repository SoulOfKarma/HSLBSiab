<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialTipos extends Model
{
    protected $fillable = [
        'descripcion_tipo_material','id_material'
    ];
}
