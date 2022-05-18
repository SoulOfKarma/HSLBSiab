<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class saldo_inventarios extends Model
{
    protected $fillable = [
        'CODART_TRACK', 'NOMBRE','GENERICO', 'CAT_FARMACIA', 'UNIMEDBASE', 'CONCENTRACION',
        'CODART_ONU','CODART','CODART_BARR', 'idEstado','ACT_FECVEN', 'LABORATORIO', 'CANTXENB', 'ACT_LOTE',
        'ACT_SERIE','idBodega','idFam1','idFam2','idFam3','idFam4','idFam5','FECVEN','LOTE','CANTIDAD','FECINV','LINEA',
        'PRECIO','idZona','SECTOR','UBICACION','CODINT2','SALDO',
       
    ];

    protected $table = 'saldo_inventario';
}
