<?php

namespace App\Http\Controllers;

use App\siab_labors;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class SiabLaborsController extends Controller
{
    public function PostLaboratorio(Request $request){
        try {
            siab_labors::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetLaboratorio(){
        try {
            $get = siab_labors::all();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutLaboratorio(Request $request)
    {
        try {
            siab_labors::where('id',$request->id)
            ->update(['LABORATORIO' => $request->LABORATORIO,'RAZONSOCIAL' => $request->RAZONSOCIAL]);

            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
