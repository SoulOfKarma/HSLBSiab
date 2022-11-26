<?php

namespace App\Http\Controllers;

use App\DescripcionFamilia04;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class DescripcionFamilia04Controller extends Controller
{
    public function GetFamilia(){
        try {
            $get = DescripcionFamilia04::orderby('descripcionFamilia','ASC')
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostFamilia(Request $request){
        try {
            DescripcionFamilia04::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutFamilia(Request $request){
        try {
            DescripcionFamilia04::where('id',$request->id)
            ->update(['descripcionFamilia' => $request->descripcionFamilia,'idDesFam03' => $request->idDesFam03]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
