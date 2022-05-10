<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class siab_labors extends Model
{
    protected $fillable = [
        'LABORATORIO','RAZONSOCIAL',       
    ];

    protected $table = 'siab_labor';
}
