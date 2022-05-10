<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class centrocostos extends Model
{
    protected $fillable = [
        'CODCEN','NOMCEN',       
    ];

    protected $table = 'centrocosto';
}
