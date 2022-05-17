<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class siab_articulos extends Model
{
    protected $fillable = [
        'CODART_TRACK', 'NOMBRE','GENERICO', 'CAT_FARMACIA', 'UNIMEDBASE', 'CONCENTRACION',
        'CODART_ONU','CODART','CODART_BARR', 'idEstado','ACT_FECVEN', 'LABORATORIO', 'CANTXENB', 'ACT_LOTE',
        'ACT_SERIE','idBodega','idFam1','idFam2','idFam3','idFam4','idFam5','STOCK_MIN','STOCK_MAX','STOCK_CRI','UBICACION','idZona',
        'SECTOR','DESCR_ART','NOMARCH','CODBAR2','ART_ESP','ZCEN','CODUNIFAR','ZGEN',
       
    ];

    protected $table = 'siab_articulo';
}
