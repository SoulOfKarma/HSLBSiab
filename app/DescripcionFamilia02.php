<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DescripcionFamilia02 extends Model
{
    protected $fillable = [
        'descripcionFamilia','idDesFam01',
    ];

    protected $table = 'descripcion_familia02';
}
