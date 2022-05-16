<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DescripcionFamilia03 extends Model
{
    protected $fillable = [
        'descripcionFamilia','idDesFam02',
    ];

    protected $table = 'descripcion_familia03';
}
