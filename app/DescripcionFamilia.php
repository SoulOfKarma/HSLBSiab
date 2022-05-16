<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DescripcionFamilia extends Model
{
    protected $fillable = [
        'descripcionFamilia','idBodega',
    ];

    protected $table = 'descripcion_familia';
}
