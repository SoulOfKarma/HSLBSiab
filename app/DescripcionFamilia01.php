<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DescripcionFamilia01 extends Model
{
    protected $fillable = [
        'descripcionFamilia','idDesFam',
    ];

    protected $table = 'descripcion_familia01';
}
