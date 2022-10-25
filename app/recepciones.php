<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class recepciones extends Model
{
    protected $fillable = [
        'FOLIO','FECSYS','FECDES','RUTPRO','NOMPRO','TIPBOB','NUMDOC','NUMFAC','FECFAC','CODDIG',
        'NOMDIG','NUMORD','TIPDOC','FECDOC','DCTO','OBS','CARGO','SUBTOTAL','AJUSTE','USUING',
        'USUMOD','NUMINT','NUMREC_RF','NOTCRE_RF','NUMRIB','NOMARCH','NOMARCH_RIB','NOMARCH_CAR',
        'NOMSER','idTipoCompra','NUMLIBPED','TIPRECEPCION','TIPORD'
    ];
}
