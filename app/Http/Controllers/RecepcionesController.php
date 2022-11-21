<?php

namespace App\Http\Controllers;

use App\recepciones;
use Illuminate\Http\Request;
use App\recepcionDetalles;
use App\despachos;
use App\despachoDetalles;
use DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;

class RecepcionesController extends Controller
{
    public function GetDetallesRecepcionesAnulados(){
        try {
            $get = DB::select('select COUNT(recepcion_detalles.FOLIO) AS contador,COUNT(recepcion_detalles.CODMOT) AS contadorAnulacion,
            recepciones.NUMINT,recepciones.FOLIO,recepciones.NUMORD,recepciones.FECDES,recepciones.RUTPRO,recepciones.NOMPRO,recepciones.NUMDOC,
            recepciones.NUMRIB,recepciones.USUING,recepciones.OBS
            FROM recepciones
            JOIN recepcion_detalles ON recepciones.FOLIO = recepcion_detalles.FOLIO
            WHERE recepcion_detalles.FOLIO = recepciones.FOLIO 
            GROUP BY recepciones.NUMINT,recepciones.FOLIO,recepciones.NUMORD,recepciones.FECDES,recepciones.RUTPRO,recepciones.NOMPRO,recepciones.NUMDOC,
            recepciones.NUMRIB,recepciones.USUING,recepciones.OBS
            HAVING (contador)-(contadorAnulacion) = 0
            ');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetUltimoNInterno(){
        try {
            $get = recepciones::select(DB::raw('MAX(cast(NUMINT AS UNSIGNED)) AS NUMINT'))->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetUltimoNFolio(){
        try {
            $get = recepciones::select(DB::raw('MAX(cast(FOLIO AS UNSIGNED)) AS FOLIO'))->get();
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
            $get = recepciones::select('AJUSTE','CARGO','CODDIG','DCTO','FECDES','FECDOC','FECFAC',
            'FECSYS','FOLIO','NOMARCH','NOMARCH_CAR','NOMARCH_RIB','NOMDIG','NOMPRO','NOMPRO','NOTCRE_RF',
            'NUMDOC','NUMFAC','NUMINT','NUMLIBPED','NUMORD','NUMREC_RF','NUMRIB',
            DB::raw('fnStripTags(OBS) as OBS'),'RUTPRO','SUBTOTAL','TIPBOB','TIPDOC','TIPORD',
            'TIPRECEPCION','USUING','USUMOD','id','NOMSER','idTipoCompra')
            ->where('FOLIO',null)
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetRecepcionCerradas(Request $request){
        try {
            $get = recepciones::select('AJUSTE','CARGO','CODDIG','DCTO','FECDES','FECDOC','FECFAC',
            'FECSYS','FOLIO','NOMARCH','NOMARCH_CAR','NOMARCH_RIB','NOMDIG','NOMPRO','NOMPRO','NOTCRE_RF',
            'NUMDOC','NUMFAC','NUMINT','NUMLIBPED','NUMORD','NUMREC_RF','NUMRIB',
            DB::raw('fnStripTags(OBS) as OBS'),'RUTPRO','SUBTOTAL','TIPBOB','TIPDOC','TIPORD',
            'TIPRECEPCION','USUING','USUMOD','id','NOMSER','idTipoCompra')
            ->whereNotNull('FOLIO')
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetArticulosIngresadosByCodInterno(Request $request){
        try {
            $get = recepcionDetalles::select('ACT_FECVEN','AJUSTE','CANREC','CANRECH','CANTIDAD','CARGO',
            'CODART','CODART_OC','CODBAR','CODINT2','CODMOT','DCTO','ESPCOM','ESPPRO','FECDES',
            'FECSYS','FECVEN','FL','FOLIO','IMPADICIONAL','IVA','LINEA','LOTE','MARCA','NOMMOT',
            'NUMINT','PENDIENTE','PREUNI','PREUNI2','PRODUCTO','TOTREC','UNIMED','USUING','USUMOD',
            DB::raw("ROUND(VALTOT,0) as VALTOT"),'id')
            ->where('NUMINT',$request->NUMINT)
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetRecepcionIngresadaByCodInterno(Request $request){
        try {
            $get = recepciones::select('FOLIO','FECSYS','FECDES','RUTPRO','NOMPRO','NUMDOC','NUMFAC',
            'TIPDOC','FECDOC','DCTO',DB::raw('fnStripTags(OBS) as OBS'),'CARGO',DB::raw("ROUND(SUBTOTAL,0) as SUBTOTAL"),'AJUSTE','FECSYS','USUING','USUMOD','TIPORD',
            'FECSYS','NUMINT','NUMRIB','TIPRECEPCION','NUMORD','NUMLIBPED','NOMSER','NOMARCH',
            DB::raw("ROUND(SUBTOTAL,0) as NETO"),DB::raw("ROUND((SUBTOTAL*0.19),0) as IVA"),DB::raw("ROUND((SUBTOTAL*0.19) + SUBTOTAL,0)+AJUSTE+CARGO-DCTO as TOTAL"))
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

    public function GetRecepcionCerradaOC(){
        try {
            $get = recepciones::select('recepciones.FOLIO','recepciones.FECSYS','recepciones.FECDES','recepciones.RUTPRO',
            'recepciones.NOMPRO','recepciones.NUMDOC','recepciones.NUMFAC','tipo_documentos.descripcionDocumento','recepciones.FECDOC','recepciones.DCTO',
            'recepciones.OBS','recepciones.CARGO','recepciones.SUBTOTAL','recepciones.AJUSTE','recepciones.FECSYS','recepciones.USUING',
            'recepciones.USUMOD','recepciones.FECSYS','recepciones.NUMINT','recepciones.NUMRIB','recepciones.TIPRECEPCION','recepciones.NUMORD',
            DB::raw("recepciones.SUBTOTAL as NETO"),DB::raw("ROUND((recepciones.SUBTOTAL*0.19),2) as IVA"),
            DB::raw("ROUND((recepciones.SUBTOTAL*0.19) + recepciones.SUBTOTAL,2) as TOTAL"))
            ->join('tipo_documentos','recepciones.TIPDOC','=','tipo_documentos.id')
            ->leftjoin('orden_compra_detalles','recepciones.FOLIO','=','orden_compra_detalles.FOLREC')
            ->whereNotNull('recepciones.FOLIO')
            ->whereNull('orden_compra_detalles.FOLREC')
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
            'OBS' => $request->OBS,'CARGO' => $request->CARGO,'AJUSTE' => $request->AJUSTE,'NOMSER' => $request->NOMSER,
            'NUMLIBPED' => $request->NUMLIBPED,'TIPRECEPCION' => $request->TIPRECEPCION,'TIPORD' => $request->TIPORD]);
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

    public function PostCerrarRecepcionDespacho(Request $request){
        try {
            //despachoDetalles::insert($request->all());

            $lista = $request->all();
            
            foreach($lista as $e => $req ){    
                $despachoDetalles = new despachoDetalles;
                $despachoDetalles->FOLIO = $req['FOLIO'];
                $despachoDetalles->FECSYS = $req['FECSYS'];
                $despachoDetalles->FECDES = $req['FECDES'];
                $despachoDetalles->NOMSER = $req['NOMSER'];
                $despachoDetalles->NUMLIBRO = $req['NUMLIBRO'];
                $despachoDetalles->LOTE = $req['LOTE'];
                $despachoDetalles->FECVEN = $req['FECVEN'];
                $despachoDetalles->CODBAR = $req['CODBAR'];
                $despachoDetalles->CODART = $req['CODART'];
                $despachoDetalles->NOMART = $req['PRODUCTO'];
                $despachoDetalles->UNIMED = $req['UNIMED'];
                $despachoDetalles->CANTIDAD = $req['CANREC'];
                $despachoDetalles->PRECIO = $req['PREUNI'];
                $despachoDetalles->ACT_FECVEN = $req['ACT_FECVEN'];
                $despachoDetalles->USUING = $req['USUING'];
                $despachoDetalles->NUMINT = $req['NUMINT'];
                $despachoDetalles->TIPDESP = $req['TIPDESP'];
                $despachoDetalles->save();
                    
            }
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostCerrarDespacho(Request $request){
        try {
            despachos::create($request->all());
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
            ->update(['SUBTOTAL' => $request->SUBTOTAL,'TIPORD' => $request->TIPORD,'NUMORD' => $request->NUMORD,
            'DCTO' => $request->DCTO,'CARGO' => $request->CARGO,'AJUSTE' => $request->AJUSTE,'OBS' => $request->OBS,
            'FECDES' => $request->FECDES,'RUTPRO' => $request->RUTPRO,'NOMPRO' => $request->NOMPRO,'NUMRIB' => $request->NUMRIB,
            'TIPDOC' => $request->TIPDOC,'NUMDOC' => $request->NUMDOC,'FECDOC' => $request->FECDOC,'NUMLIBPED' => $request->NUMLIBPED,
            'TIPRECEPCION' => $request->TIPRECEPCION,'USUING' => $request->USUING,'NOMSER' => $request->NOMSER]); 
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

    public function DeleteArticuloDespachoDetalle(Request $request){
        try {
           recepcionDetalles::where('id', $request->id)->delete();
           return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;       
        }
    }

    public function PostAnularArticulo(Request $request){
        try {
            recepcionDetalles::where('id',$request->id)
            ->update(['CODMOT' => $request->CODMOT,'NOMMOT' => $request->NOMMOT]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostRAnularArticulo(Request $request){
        try {
            recepcionDetalles::where('id',$request->id)
            ->update(['CODMOT' => null,'NOMMOT' => null]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostAnularTodo(Request $request){
        try {
            recepcionDetalles::where('NUMINT',$request->NUMINT)
            ->update(['CODMOT' => $request->CODMOT,'NOMMOT' => $request->NOMMOT]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GenerarImpresion($NUMINT){
        try {
            $getDet = recepcionDetalles::select('CODART','PRODUCTO','UNIMED','LOTE',DB::raw("DATE_FORMAT(FECVEN,'%d/%m/%Y') as FECVEN"),'CANREC','PREUNI',
            DB::raw('ROUND(VALTOT,0) as VALTOT'))
            ->where('NUMINT',$NUMINT)
            ->get();

            $getRec = recepciones::select('FOLIO',DB::raw("DATE_FORMAT(recepciones.FECSYS,'%d/%m/%Y') as FECSYS"),
            DB::raw("DATE_FORMAT(recepciones.FECDES,'%d/%m/%Y') as FECDES"),'recepciones.RUTPRO','recepciones.NOMPRO',
            'recepciones.NUMDOC','recepciones.NUMORD','tipo_documentos.descripcionDocumento as TIPDOC',
            DB::raw("DATE_FORMAT(recepciones.FECDOC,'%d/%m/%Y') as FECDOC"),'recepciones.DCTO',
            DB::raw('fnStripTags(recepciones.OBS) AS OBS'),'recepciones.CARGO',DB::raw('ROUND(recepciones.SUBTOTAL,0) as SUBTOTAL'),
            'recepciones.AJUSTE','recepciones.USUING','recepciones.USUMOD','recepciones.NUMINT',
            'recepciones.NUMRIB','recepciones.TIPRECEPCION',DB::raw("ROUND(recepciones.SUBTOTAL,0) as NETO"),
            DB::raw("ROUND((recepciones.SUBTOTAL*0.19),0) as IVA"),
            DB::raw("ROUND((recepciones.SUBTOTAL*0.19) + recepciones.SUBTOTAL,0) as TOTAL"))
            ->where('recepciones.NUMINT',$NUMINT)
            ->join('tipo_documentos','recepciones.TIPDOC','=','tipo_documentos.id')
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

    //Subir Documentos
    public function PostDocumentoRecepcionFactura(Request $request)
    {
        try {
            if ($request->hasFile('avatar')) {
                // Si es así , almacenamos en la carpeta public/avatars
                // esta estará dentro de public/defaults/
               
               $url = $request->avatar->store('users/Documentacion');
               recepciones::where('NUMINT', $request->id)
                ->update(['NOMARCH' => $url]);
               return true;
            }else{
                log::info("No hay archivo");
                return back()->with('error', 'Missing image!');
            }
            
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function DestroyDocumentoRecepcionFactura(Request $request){
        try {
            $res=recepciones::where('NUMINT',$request->id)
            ->update(['NOMARCH' => ""]);
               return true;
            if($res){
              return true;
            }
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostDocumentoRecepcionFacturaRib(Request $request)
    {
        try {
            if ($request->hasFile('avatar')) {
                // Si es así , almacenamos en la carpeta public/avatars
                // esta estará dentro de public/defaults/
               
               $url = $request->avatar->store('users/Documentacion');
               recepciones::where('NUMINT', $request->id)
                ->update(['NOMARCH_RIB' => $url]);
               return true;
            }else{
                log::info("No hay archivo");
                return back()->with('error', 'Missing image!');
            }
            
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function DestroyDocumentoRecepcionFacturaRib(Request $request){
        try {
            $res=recepciones::where('NUMINT',$request->id)
            ->update(['NOMARCH_RIB' => ""]);
               return true;
            if($res){
              return true;
            }
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostDocumentoRecepcionFacturaCarta(Request $request)
    {
        try {
            if ($request->hasFile('avatar')) {
                // Si es así , almacenamos en la carpeta public/avatars
                // esta estará dentro de public/defaults/
               
               $url = $request->avatar->store('users/Documentacion');
               recepciones::where('NUMINT', $request->id)
                ->update(['NOMARCH_CAR' => $url]);
               return true;
            }else{
                log::info("No hay archivo");
                return back()->with('error', 'Missing image!');
            }
            
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function DestroyDocumentoRecepcionFacturaCarta(Request $request){
        try {
            $res=recepciones::where('NUMINT',$request->id)
            ->update(['NOMARCH_CAR' => ""]);
               return true;
            if($res){
              return true;
            }
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

}
