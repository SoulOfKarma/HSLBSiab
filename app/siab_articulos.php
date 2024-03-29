<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class siab_articulos extends Model
{
    protected $fillable = [
        'CODART_TRACK', 'NOMBRE','GENERICO', 'CAT_FARMACIA', 'UNIMEDBASE', 'CONCENTRACION',
        'CODART_ONU','CODART','CODART_BARR', 'idEstado','ACT_FECVEN', 'LABORATORIO', 'CANTXENB', 'ACT_LOTE',
        'ACT_SERIE','idBodega','NOMFAM1','NOMFAM2','NOMFAM3','NOMFAM4','NOMFAM5','STOCK_MIN','STOCK_MAX','STOCK_CRI','UBICACION','idZona',
        'SECTOR','DESCR_ART','NOMARCH','CODBAR2','ART_ESP','ZCEN','CODUNIFAR','ZGEN','COVID','PRECIO_BASE'
       
    ];

    protected $table = 'siab_articulo';
}
