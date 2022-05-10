<?php

namespace App\Http\Controllers;

use App\siab_proveedores;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class SiabProveedoresController extends Controller
{
    public function PostProveedor(Request $request){
        try {
            siab_proveedores::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetProveedor(){
        try {
            $get = siab_proveedores::all();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutProveedor(Request $request)
    {
        try {
            siab_proveedores::where('id',$request->id)
            ->update(['RUTPROV' => $request->RUTPROV,'NOMRAZSOC' => $request->NOMRAZSOC,'DIRPROV' => $request->DIRPROV,
            'TELPROV' => $request->TELPROV,'CELPROV' => $request->CELPROV,'EMAILPROV' => $request->EMAILPROV,'NOMVENPROV' => $request->NOMVENPROV]);

            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

}
