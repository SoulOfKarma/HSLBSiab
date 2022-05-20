<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DescripcionFamilia02 extends Model
{
    protected $fillable = [
        'descripcionFamilia','CODFAM3','idDesFam01'
    ];

    protected $table = 'descripcion_familia02';
}
