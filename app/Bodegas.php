<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bodegas extends Model
{
    protected $fillable = [
        'descripcionBodega',  
    ];

    protected $table = 'bodega';
}
