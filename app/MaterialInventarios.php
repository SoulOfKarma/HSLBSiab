<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialInventarios extends Model
{
    protected $fillable = [
        'id_ubicaciones','id_servicios',
        'id_material_ing','id_material_tipo',
        'id_cant_esp','id_material_medida',
        'material_cantidad','material_valor'
    ];
}
