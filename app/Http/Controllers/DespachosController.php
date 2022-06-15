<?php

namespace App\Http\Controllers;

use App\despachos;
use App\despachoDetalles;
use App\saldo_inventarios;
use App\recepcionDetalles;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;

class DespachosController extends Controller
{
    public function GetDetallesArticulosDisponibles(){
        try {
            $get = DB::select('select SUM(t.saldo) AS saldo,
            CASE WHEN despacho_detalles.CODMOT IS NOT NULL
            THEN SUM(t.saldo) 
            WHEN despacho_detalles.CODMOT IS NULL
            THEN COALESCE((SUM(t.saldo) - COALESCE(despacho_detalles.CANTIDAD,0)),SUM(t.saldo))
            END AS saldoCorrecto,
                        t.NOMBRE,t.CODBAR,t.LOTE,t.UNIMED,t.CODART,t.diasVencimiento,t.fechaVencimiento,t.PREUNI
                            from (select SUM(recepcion_detalles.CANREC) as saldo, recepcion_detalles.PRODUCTO AS NOMBRE,
                          recepcion_detalles.CODBAR AS CODBAR,COALESCE(recepcion_detalles.LOTE,"No tiene LOTE") AS LOTE,recepcion_detalles.UNIMED AS UNIMED,recepcion_detalles.CODART AS CODART,
                          COALESCE(TIMESTAMPDIFF(DAY,NOW(),recepcion_detalles.FECVEN)+1,0) as diasVencimiento,COALESCE(recepcion_detalles.FECVEN,"No tiene Fecha") AS fechaVencimiento,
                          recepcion_detalles.PREUNI AS PREUNI
                          from recepcion_detalles 
                          group by NOMBRE,CODBAR,LOTE,UNIMED,CODART,diasVencimiento,fechaVencimiento,PREUNI
                  
                          union all
                  
                          select SUM(saldo_inventario.SALDO) as saldo, saldo_inventario.NOMBRE AS NOMBRE,
                           saldo_inventario.CODART_BARR AS CODBAR,COALESCE(saldo_inventario.LOTE,"No tiene LOTE") AS LOTE,saldo_inventario.UNIMEDBASE AS UNIMED,saldo_inventario.CODART AS CODART,
                           COALESCE(TIMESTAMPDIFF(DAY,NOW(),saldo_inventario.FECVEN)+1,0) as diasVencimiento,COALESCE(saldo_inventario.FECVEN,"No tiene Fecha") AS fechaVencimiento,
                           saldo_inventario.PRECIO AS PREUNI
                          from saldo_inventario 
                          group by NOMBRE,CODBAR,LOTE,UNIMED,CODART,diasVencimiento,fechaVencimiento,PREUNI
                          
                          ) t
                          LEFT JOIN despacho_detalles ON t.LOTE = despacho_detalles.LOTE
                  group by despacho_detalles.CANTIDAD,t.NOMBRE,t.CODBAR,t.LOTE,t.UNIMED,t.CODART,t.diasVencimiento,t.fechaVencimiento,t.PREUNI,despacho_detalles.CODMOT
            ');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostDespacho(Request $request){
        try {
            despachos::create($request->all());
            despachoDetalles::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostDetalleDespacho(Request $request){
        try {
            despachoDetalles::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetUltimoNInternoDespacho(){
        try {
            $get = despachos::max('NUMINT');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetUltimoNFolioDespacho(){
        try {
            $get = despachos::max('FOLIO');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetDespachosAbiertos(){
        try {
            $get = despachos::select('despachos.NUMINT','despachos.FOLIO','despachos.FECDES','servicios.descripcionServicio',
            'despachos.NUMLIBRO','despachos.USUING')
            ->join('servicios','despachos.idServicio','=','servicios.id')
            ->where('FOLIO',null)
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetDespachosCerrados(){
        try {
            $get = despachos::select('despachos.NUMINT','despachos.FOLIO','despachos.FECDES','servicios.descripcionServicio',
            'despachos.NUMLIBRO','despachos.USUING')
            ->join('servicios','despachos.idServicio','=','servicios.id')
            ->whereNotNull('despachos.FOLIO')
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetDespachos(Request $request){
        try {
            $get = despachos::select('despachos.NUMINT','despachos.FOLIO','despachos.FECSYS','despachos.FECDES','despachos.idServicio','servicios.descripcionServicio',
            'despachos.NUMLIBRO','despachos.USUING','despachos.TIPDESP','despachos.OBS')
            ->join('servicios','despachos.idServicio','=','servicios.id')
            ->where('despachos.NUMINT',$request->NUMINT)
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetDespachoDetalles(Request $request){
        try {
            $get = despachoDetalles::select('despacho_detalles.id','despacho_detalles.FECSYS','despacho_detalles.FECDES','despacho_detalles.NUMLIBRO',
            'despacho_detalles.LOTE','despacho_detalles.FECVEN','despacho_detalles.CODBAR','despacho_detalles.CODART','despacho_detalles.NOMART',
            'despacho_detalles.UNIMED','despacho_detalles.CANTIDAD','despacho_detalles.PRECIO','despacho_detalles.NUMINT','despacho_detalles.CODMOT','despacho_detalles.NOMMOT',
            DB::raw("ROUND((despacho_detalles.CANTIDAD*despacho_detalles.PRECIO),2) as VALORTOTALDESP"))
            ->where('despacho_detalles.NUMINT',$request->NUMINT)
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostQuitarArticuloDespacho(Request $request){
        try {
            despachoDetalles::where('id', $request->id)->delete();
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutDespacho(Request $request){
        try {
            despachos::where('NUMINT',$request->NUMINT)
            ->update(['FECDES' => $request->FECDES,'idServicio' => $request->idServicio,'NUMLIBRO' => $request->NUMLIBRO,
            'TIPDESP' => $request->TIPDESP,'NUMSOL' => $request->NUMSOL,'OBS' => $request->OBS]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function CerrarDespacho(Request $request){
        try {
            despachos::where('NUMINT',$request->NUMINT)
            ->update(['FOLIO' => $request->FOLIO]);
            despachoDetalles::where('NUMINT',$request->NUMINT)
            ->update(['FOLIO' => $request->FOLIO]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostAnularArticulo(Request $request){
        try {
            despachoDetalles::where('id',$request->id)
            ->update(['CODMOT' => $request->CODMOT,'NOMMOT' => $request->NOMMOT]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GenerarImpresion($NUMINT){
        try {
            $getDet = despachoDetalles::select('despacho_detalles.id','despacho_detalles.FECSYS','despacho_detalles.FECDES','despacho_detalles.NUMLIBRO',
            'despacho_detalles.LOTE','despacho_detalles.FECVEN','despacho_detalles.CODBAR','despacho_detalles.CODART','despacho_detalles.NOMART',
            'despacho_detalles.UNIMED','despacho_detalles.CANTIDAD','despacho_detalles.PRECIO','despacho_detalles.NUMINT','despacho_detalles.CODMOT','despacho_detalles.NOMMOT',
            DB::raw("ROUND((despacho_detalles.CANTIDAD*despacho_detalles.PRECIO),2) as VALORTOTALDESP"))
            ->where('despacho_detalles.NUMINT',$NUMINT)
            ->get();

            $getRec = despachos::select('despachos.NUMINT','despachos.FOLIO','despachos.FECSYS','despachos.FECDES','despachos.idServicio','servicios.descripcionServicio',
            'despachos.NUMLIBRO','despachos.USUING','despachos.TIPDESP',DB::raw('fnStripTags(despachos.OBS) as OBS'))
            ->join('servicios','despachos.idServicio','=','servicios.id')
            ->where('despachos.NUMINT',$NUMINT)
            ->get();

            $pdf = App::make("dompdf.wrapper");
            $pdf->loadView('Despacho', compact ('getDet','getRec'));
            $pdf->setOptions(['isJavascriptEnabled' => true]);
            $pdf->setOptions(['isRemoteEnabled' => true]);
            return $pdf->stream("Despacho.pdf", array("Attachment" => 0));
        } catch (\Throwable $th) {
            log::info($th);
            return false;  
        }
    }
 
}
