<?php

namespace App\Http\Controllers;

use App\autorizadoretiros;
use Illuminate\Http\Request;

class AutorizadoretirosController extends Controller
{
    public function PostAuthUsuario(Request $request){
        try {
            autorizadoretiros::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetAuthUsuario(){
        try {
            $get = autorizadoretiros::all();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutAuthUsuario(Request $request)
    {
        try {
            autorizadoretiros::where('id',$request->id)
            ->update(['CODMOT' => $request->CODMOT,'NOMMOT' => $request->NOMMOT]);

            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
