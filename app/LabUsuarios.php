<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabUsuarios extends Model
{
    protected $fillable = [
        'RUN','nombreUsuLab','apellidoUsuLab',
    ];
}
