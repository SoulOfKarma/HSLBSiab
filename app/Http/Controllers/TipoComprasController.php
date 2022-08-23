<?php

namespace App\Http\Controllers;

use App\TipoCompras;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class TipoComprasController extends Controller
{
    public function GetTipoCompras(){
        try {
            $get = TipoCompras::all();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostTipoCompras(Request $request){
        try {
            TipoCompras::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutTipoCompras(Request $request){
        try {
            TipoCompras::where('id',$request->id)
            ->update(['NOMTIPCOM' => $request->NOMTIPCOM,'CATTIPCOM' => $request->CATTIPCOM]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
