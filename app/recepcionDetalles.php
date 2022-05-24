<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class recepcionDetalles extends Model
{
    protected $fillable = [
        'FOLIO','FECSYS','FECDES','LINEA','CODBAR','IVA','CODART_OC','PRODUCTO','CANTIDAD','ESPCOM',
        'ESPPRO','PREUNI','VALTOT','DCTO','CARGO','IMPADICIONAL','CANREC','CANRECH','TOTREC','FL',
        'MARCA','PREUNI2','UNIMED','PENDIENTE','CODART','LOTE','FECVEN','ACT_FECVEN',
        'AJUSTE','USUING','USUMOD','NUMINT','CODMOT','NOMMOT','CODINT2',
    ];
}
