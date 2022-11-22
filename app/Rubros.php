<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rubros extends Model
{
    protected $fillable = [
        'CODSEC','NOMSEC','DESSEC',
    ];
}
