<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialInventarios extends Model
{
    protected $fillable = [
        'id_ubicaciones','id_servicios','id_cubiculo',
        'id_material_ing',
        'id_cant_esp','id_material_medida',
        'material_cantidad','material_valor','material_cantidad_calculada',
        'id_documento','n_documento','id_estados'
    ];
}
