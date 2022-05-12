<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentacionAuthUsuarios extends Model
{
    protected $fillable = [
        'idAuthUsuario','nombreDocOriginal','nombreDocAutogenerado',  
    ];
}
