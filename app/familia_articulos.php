<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class familia_articulos extends Model
{
    protected $fillable = [
        'CODFAM1', 'NOMFAM1','CODFAM2','NOMFAM2','CODFAM3','NOMFAM3',
        'CODFAM4','NOMFAM4','CODFAM5','NOMFAM5','CODFAM6','NOMFAM6',
        'CODFAM7','NOMFAM7','BODEGA',
       
    ];

    protected $table = 'familia_articulo';
}
