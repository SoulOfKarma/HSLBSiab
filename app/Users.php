<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Users extends Authenticatable implements JWTSubject
{
    protected $fillable = [
        'id', 'run','correo_usuario', 'nombre_usuario', 'apellido_usuario', 'anexo',
        'password',
       
    ];

    protected $hidden = ['password'];

    public function getJWTIndentifier(){
        return $this->getKey();
    }
    public function getJWTCustomClaims(){
        return [];
    }
}
