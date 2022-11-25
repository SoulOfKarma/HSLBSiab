<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ordenCompraDetalles extends Model
{
    protected $fillable = [
        'FOLIO','RUTPRO','NOMPRO','FECORD','NUMINT','NUMSIGFE',
        'TIPDOC','NUMDOC','FECDOC','TOTAL','FECSYS','FOLREC','NOMORD','ANIO',
    ];
}
