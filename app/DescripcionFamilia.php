<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DescripcionFamilia extends Model
{
    protected $fillable = [
        'descripcionFamilia','idBodega','CODFAM1',
    ];

    protected $table = 'descripcion_familia';
}
