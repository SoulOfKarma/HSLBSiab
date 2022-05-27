<?php

namespace App\Http\Controllers;

use App\recepciones;
use Illuminate\Http\Request;
use App\recepcionDetalles;
use DB;
use Illuminate\Support\Facades\Log;

class RecepcionesController extends Controller
{
    public function GetUltimoNInterno(){
        try {
            $get = recepciones::max('NUMINT');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetRecepcionAbiertaByCodInteno(Request $request){
        try {
            $get = recepciones::where('NUMINT',$request->NUMINT)
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetRecepcionAbiertas(Request $request){
        try {
            $get = recepciones::where('FOLIO',null)
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetArticulosIngresadosByCodInterno(Request $request){
        try {
            $get = recepcionDetalles::where('NUMINT',$request->NUMINT)
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetRecepcionIngresadaByCodInterno(Request $request){
        try {
            $get = recepciones::select('FECSYS','FECDES','RUTPRO','NOMPRO','NUMDOC','NUMFAC','TIPDOC','FECDOC','DCTO',
            'OBS','CARGO','SUBTOTAL','AJUSTE','FECSYS','USUING','USUMOD','FECSYS','NUMINT','NUMRIB',
            DB::raw("SUBTOTAL as NETO"),DB::raw("(SUBTOTAL*0.19) as IVA"),DB::raw("(SUBTOTAL*0.19) + SUBTOTAL as TOTAL"))
            ->where('NUMINT',$request->NUMINT)
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostArticuloDetalle(Request $request){
        try {
            recepciones::create($request->all());
            recepcionDetalles::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostArticuloDetalleCodInterno(Request $request){
        try {
            recepcionDetalles::create($request->all());
            recepciones::where('NUMINT',$request->NUMINT)
            ->update(['RUTPRO' => $request->RUTPRO,'NOMPRO' => $request->NOMPRO,'SUBTOTAL' => $request->SUBTOTAL,
            'DCTO' => $request->DCTO,'TIPDOC' => $request->TIPDOC,'NUMDOC' => $request->NUMDOC,'FECDOC' => $request->FECDOC,
            'NUMFAC' => $request->NUMFAC,'NUMRIB' => $request->NUMRIB,'USUMOD' => $request->USUMOD,
            'OBS' => $request->OBS,'CARGO' => $request->CARGO,'AJUSTE' => $request->AJUSTE]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
