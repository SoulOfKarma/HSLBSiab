<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class siab_proveedores extends Model
{
    protected $fillable = [
        'LLAVEPROVEEDOR', 'CODFORMAPAGO','CODCOM', 'CODCIU', 'CODRUB', 'CODSIT',
        'CODEST','NUMCRE','RUTPROV', 'NOMRAZSOC','NOMFAN', 'CTACTEPROV', 'DIRPROV', 'TELPROV',
        'CELPROV','FAXPROV','EMAILPROV','NOMVENPROV','CODBAN','NOMPERPOD',
       
    ];

    protected $table = 'siab_proveedor';
}
