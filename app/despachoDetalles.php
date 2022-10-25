<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class despachoDetalles extends Model
{
    protected $fillable = [
        'FOLIO','FECSYS','FECDES','NOMSER','NOMTIPCON','TIPPRE','NUMPRO','NUMLIBRO','CODDIG','NOMDIG',
        'LOTE','FECVEN','CODBAR','CODART','NOMART','UNIMED','CANTIDAD','PRECIO','CODART_TRACK','CODART_ONU',
        'TIPBOD','LINEA','ACT_FECVEN','CANTXENB','USUING','USUMOD','NUMINT','CODMOT',
        'NOMMOT','FOLIO_FCIA','FOLIO_SOL','CODINT2','ART_ESP','TIPDESP','NUMSOL',
    ];
}
