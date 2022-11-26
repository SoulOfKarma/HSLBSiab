<?php

namespace App\Http\Controllers;

use App\DescripcionFamilia01;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class DescripcionFamilia01Controller extends Controller
{
    public function GetFamilia(){
        try {
            $get = DescripcionFamilia01::orderby('descripcionFamilia','ASC')
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostFamilia(Request $request){
        try {
            DescripcionFamilia01::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutFamilia(Request $request){
        try {
            DescripcionFamilia01::where('id',$request->id)
            ->update(['descripcionFamilia' => $request->descripcionFamilia,'idDesFam' => $request->idDesFam]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
