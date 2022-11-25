<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ordenCompras extends Model
{
    protected $fillable = [
        'FOLIO','RUTPRO','NOMPRO','FECORD','NUMINT','NUMSIGFE',
        'FECSYS','OBS','ANIO'
    ];
}
