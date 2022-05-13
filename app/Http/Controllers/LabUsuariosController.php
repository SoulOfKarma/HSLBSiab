<?php

namespace App\Http\Controllers;

use App\LabUsuarios;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class LabUsuariosController extends Controller
{
    public function GetLabUsuario(){
        try {
            $get = LabUsuarios::all();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostLabUsuario(Request $request){
        try {
            LabUsuarios::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutLabUsuario(Request $request){
        try {
            LabUsuarios::where('id',$request->id)
            ->update(['RUN' => $request->RUN,'nombreUsuLab' => $request->nombreUsuLab,'apellidoUsuLab' => $request->apellidoUsuLab]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
