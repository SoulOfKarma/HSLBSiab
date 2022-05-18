<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class stockMinMax extends Model
{
    protected $fillable = [
        'idBodega', 'CODART', 'NOMBRE','STOCK_MIN', 'STOCK_MAX', 'STOCK_CRI','idEstadoStock',
    ];

    protected $table = 'stock_min_max';
}
