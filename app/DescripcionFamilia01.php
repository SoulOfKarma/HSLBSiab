<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DescripcionFamilia01 extends Model
{
    protected $fillable = [
        'descripcionFamilia','CODFAM2','idDesFam',
    ];

    protected $table = 'descripcion_familia01';
}
