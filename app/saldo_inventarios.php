<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class saldo_inventarios extends Model
{
    protected $fillable = [
        'CODART_TRACK', 'NOMBRE','GENERICO', 'CAT_FARMACIA', 'UNIMEDBASE', 'CONCENTRACION',
        'CODART_ONU','CODART','CODART_BARR', 'idEstado','ACT_FECVEN', 'LABORATORIO', 'CANTXENB', 'ACT_LOTE',
        'ACT_SERIE','idBodega','NOMFAM1','NOMFAM2','NOMFAM3','NOMFAM4','NOMFAM5','FECVEN','LOTE','CANTIDAD','FECINV','LINEA',
        'PRECIO','idZona','SECTOR','UBICACION','CODINT2','SALDO',
       
    ];

    protected $table = 'saldo_inventario';
}
