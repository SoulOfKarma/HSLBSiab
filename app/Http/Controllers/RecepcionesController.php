<?php

namespace App\Http\Controllers;

use App\recepciones;
use Illuminate\Http\Request;
use App\recepcionDetalles;
use DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;

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

    public function GetUltimoNFolio(){
        try {
            $get = recepciones::max('FOLIO');
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

    public function GetRecepcionCerradas(Request $request){
        try {
            $get = recepciones::whereNotNull('FOLIO')
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
            $get = recepciones::select('FOLIO','FECSYS','FECDES','RUTPRO','NOMPRO','NUMDOC','NUMFAC','TIPDOC','FECDOC','DCTO',
            'OBS','CARGO','SUBTOTAL','AJUSTE','FECSYS','USUING','USUMOD','FECSYS','NUMINT','NUMRIB','TIPRECEPCION','NUMORD',
            DB::raw("SUBTOTAL as NETO"),DB::raw("ROUND((SUBTOTAL*0.19),2) as IVA"),DB::raw("ROUND((SUBTOTAL*0.19) + SUBTOTAL,2) as TOTAL"))
            ->where('NUMINT',$request->NUMINT)
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetRecepcionIngresadaOrdenCompra(){
        try {
            $get = recepciones::select('recepciones.FOLIO','recepciones.FECSYS','recepciones.FECDES','recepciones.RUTPRO',
            'recepciones.NOMPRO','recepciones.NUMDOC','recepciones.NUMFAC','tipo_documentos.descripcionDocumento','recepciones.FECDOC','recepciones.DCTO',
            'recepciones.OBS','recepciones.CARGO','recepciones.SUBTOTAL','recepciones.AJUSTE','recepciones.FECSYS','recepciones.USUING',
            'recepciones.USUMOD','recepciones.FECSYS','recepciones.NUMINT','recepciones.NUMRIB','recepciones.TIPRECEPCION','recepciones.NUMORD',
            DB::raw("recepciones.SUBTOTAL as NETO"),DB::raw("ROUND((recepciones.SUBTOTAL*0.19),2) as IVA"),
            DB::raw("ROUND((recepciones.SUBTOTAL*0.19) + recepciones.SUBTOTAL,2) as TOTAL"))
            ->join('tipo_documentos','recepciones.TIPDOC','=','tipo_documentos.id')
            ->whereNotNull('FOLIO')
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
            'OBS' => $request->OBS,'CARGO' => $request->CARGO,'AJUSTE' => $request->AJUSTE,'idServicio' => $request->idServicio,
            'NUMLIBPED' => $request->NUMLIBPED,'TIPRECEPCION' => $request->TIPRECEPCION]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostCerrarRecepcion(Request $request){
        try {
            recepcionDetalles::where('NUMINT',$request->NUMINT)
            ->update(['FOLIO' => $request->FOLIO]);
            recepciones::where('NUMINT',$request->NUMINT)
            ->update(['FOLIO' => $request->FOLIO]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutListadoArticulosRecepcion(Request $request){
        try {
                $lista = $request->all();
            
                foreach($lista as $e => $req ){                           
                    recepcionDetalles::where('id',$req["id"])
                    ->update(['CODBAR' => $req["CODBAR"],'FECVEN' => $req["FECVEN"],'LOTE' => $req["LOTE"],
                    'CANREC' => $req["CANREC"],'PREUNI' => $req["PREUNI"],'VALTOT' => $req["VALTOT"]]);
                    
                }
              return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutRecepcionTotal(Request $request){
        try {
            recepciones::where('NUMINT',$request->NUMINT)
            ->update(['SUBTOTAL' => $request->SUBTOTAL]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function DeleteArticuloDetalle(Request $request){
        try {
           recepcionDetalles::where('id', $request->id)->delete();
           return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;       
        }
    }

    public function GenerarImpresion($NUMINT){
        try {
            $getDet = recepcionDetalles::where('NUMINT',$NUMINT)
            ->get();

            $getRec = recepciones::select('FOLIO','FECSYS','FECDES','RUTPRO','NOMPRO','NUMDOC','NUMORD','TIPDOC','FECDOC','DCTO',
            'OBS','CARGO','SUBTOTAL','AJUSTE','USUING','USUMOD','FECSYS','NUMINT','NUMRIB','TIPRECEPCION',
            DB::raw("SUBTOTAL as NETO"),DB::raw("ROUND((SUBTOTAL*0.19),2) as IVA"),DB::raw("ROUND((SUBTOTAL*0.19) + SUBTOTAL,2) as TOTAL"))
            ->where('NUMINT',$NUMINT)
            ->get();

            $pdf = App::make("dompdf.wrapper");
            $pdf->loadView('Recepcion', compact ('getDet','getRec'));
            $pdf->setOptions(['isJavascriptEnabled' => true]);
            $pdf->setOptions(['isRemoteEnabled' => true]);
            return $pdf->stream("Recepcion.pdf", array("Attachment" => 0));
        } catch (\Throwable $th) {
            log::info($th);
            return false;  
        }
    }
}
