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
            $get = DB::select('select (SUM(t.saldo) - COALESCE((SELECT sum(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.LOTE = t.LOTE && 
            despacho_detalles.CODMOT IS NULL && despacho_detalles.FOLIO IS NOT NULL
            GROUP BY despacho_detalles.LOTE),0))
                         AS saldoCorrecto,
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
                              group by t.NOMBRE,t.CODBAR,t.LOTE,t.UNIMED,t.CODART,t.diasVencimiento,t.fechaVencimiento,t.PREUNI
                              HAVING saldoCorrecto > 0
            ');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetDetallesDespachosAnulados(){
        try {
            $get = DB::select('select COUNT(despacho_detalles.FOLIO) AS contador,COUNT(despacho_detalles.CODMOT) AS contadorAnulacion,
            despachos.NUMINT,despachos.FOLIO,despachos.FECDES,despachos.NOMSER,despachos.NUMLIBRO,despachos.USUING
            FROM despachos
            JOIN despacho_detalles ON despachos.FOLIO = despacho_detalles.FOLIO
            WHERE despacho_detalles.FOLIO = despachos.FOLIO 
            GROUP BY despachos.NUMINT,despachos.FOLIO,despachos.FECDES,despachos.NOMSER,despachos.NUMLIBRO,despachos.USUING
            HAVING (contador)-(contadorAnulacion) = 0
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
            despachoDetalles::updateOrCreate(['NUMINT' => $request->NUMINT, 'FECSYS' => $request->FECSYS,
            'FECDES' => $request->FECDES,'CODBAR' => $request->CODBAR,'LOTE' => $request->LOTE,
            'UNIMED' => $request->UNIMED,'CODART' => $request->CODART],
            ['NUMINT' => $request->NUMINT, 'FECSYS' => $request->FECSYS,'FECVEN' => $request->FECVEN,
            'FECDES' => $request->FECDES,'NOMSER' => $request->NOMSER,'TIPDESP' => $request->TIPDESP,
            'NUMSOL' => $request->NUMSOL,'NUMLIBRO' => $request->NUMLIBRO,'NOMART' => $request->NOMART,
            'CODBAR' => $request->CODBAR,'LOTE' => $request->LOTE,'UNIMED' => $request->UNIMED,'CODART' => $request->CODART,
            'PRECIO' => $request->PRECIO,'CANTIDAD' => $request->CANTIDAD,'USUING' => $request->USUING]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostDetalleDespacho(Request $request){
        try {
            despachoDetalles::updateOrCreate(['NUMINT' => $request->NUMINT, 'FECSYS' => $request->FECSYS,
            'FECDES' => $request->FECDES,'CODBAR' => $request->CODBAR,'LOTE' => $request->LOTE,
            'UNIMED' => $request->UNIMED,'CODART' => $request->CODART],
            ['NUMINT' => $request->NUMINT, 'FECSYS' => $request->FECSYS,'FECVEN' => $request->FECVEN,
            'FECDES' => $request->FECDES,'NOMSER' => $request->NOMSER,'TIPDESP' => $request->TIPDESP,
            'NUMSOL' => $request->NUMSOL,'NUMLIBRO' => $request->NUMLIBRO,'NOMART' => $request->NOMART,
            'CODBAR' => $request->CODBAR,'LOTE' => $request->LOTE,'UNIMED' => $request->UNIMED,'CODART' => $request->CODART,
            'PRECIO' => $request->PRECIO,'CANTIDAD' => $request->CANTIDAD,'USUING' => $request->USUING]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetUltimoNInternoDespacho(){
        try {
            $get = despachos::select(DB::raw("MAX(CAST(NUMINT AS UNSIGNED)) as NUMINT"))
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetUltimoNFolioDespacho(){
        try {
            $get = despachos::select(DB::raw("MAX(CAST(FOLIO AS UNSIGNED)) as FOLIO"))
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetDespachosAbiertos(){
        try {
            $get = despachos::select('despachos.NUMINT','despachos.FOLIO','despachos.FECDES','despachos.NOMSER',
            'despachos.NUMLIBRO','despachos.USUING','despachos.NUMPESP','despachos.OBS')
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
            $get = despachos::select('despachos.NUMINT','despachos.FOLIO','despachos.FECDES','despachos.NOMSER',
            'despachos.NUMLIBRO','despachos.USUING')
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
            $get = despachos::select('despachos.NUMINT','despachos.FOLIO','despachos.FECSYS','despachos.FECDES','despachos.NOMSER',
            'despachos.NUMLIBRO','despachos.USUING','despachos.TIPDESP','despachos.NUMPESP','despachos.OBS')
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
            ->update(['FECDES' => $request->FECDES,'NOMSER' => $request->NOMSER,'NUMLIBRO' => $request->NUMLIBRO,
            'TIPDESP' => $request->TIPDESP,'NUMSOL' => $request->NUMSOL,'OBS' => $request->OBS,
            'NUMPESP' => $request->NUMPESP]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutDespachoObservaciones(Request $request){
        try {
            despachos::where('NUMINT',$request->NUMINT)
            ->update(['OBS' => $request->OBS]);
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

    public function PostRAnularArticulo(Request $request){
        try {
            despachoDetalles::where('id',$request->id)
            ->update(['CODMOT' => null,'NOMMOT' => null]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostAnularTodo(Request $request){
        try {
            despachoDetalles::where('NUMINT',$request->NUMINT)
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
            ->whereNull('despacho_detalles.CODMOT')
            ->orWhere('despacho_detalles.CODMOT','')
            ->get();

            $getRec = despachos::select('despachos.NUMINT','despachos.FOLIO','despachos.FECSYS','despachos.FECDES','despachos.NOMSER',
            'despachos.NUMLIBRO','despachos.USUING','despachos.TIPDESP',DB::raw('fnStripTags(despachos.OBS) as OBS'))
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
