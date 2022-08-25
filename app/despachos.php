<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class despachos extends Model
{
    protected $fillable = [
        'FOLIO','FECSYS','FECDES','idServicio','NOMTIPCON','TIPPRE','NUMPRO','NUMLIBRO','CODDIG','NOMDIG',
        'TIPBOD','OBS','CODART_ONU','TIPBOD','USUING','USUMOD','NUMINT','FOLIO_FCIA','FOLIO_SOL','TIPDESP',
        'NUMSOL','NUMPESP'
    ];
}
