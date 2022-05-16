<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zonas extends Model
{
    protected $fillable = [
        'descripcionZonas',
    ];

    protected $table = 'zona';
}
