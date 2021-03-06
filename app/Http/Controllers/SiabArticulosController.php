<?php

namespace App\Http\Controllers;

use App\siab_articulos;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SiabArticulosController extends Controller
{
    public function PostMedicamentos(Request $request){
        try {
            siab_articulos::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostCodMedicamentos(Request $request){
        try {
            siab_articulos::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostInsumoEconomato(Request $request){
        try {
            siab_articulos::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostImagen(Request $request){
        try {
            if ($request->hasFile('avatar')) {
                // Si es así , almacenamos en la carpeta public/avatars
                // esta estará dentro de public/defaults/
               
               $url = $request->avatar->store('imagenArticulos');
               return $url;
            }else{
                log::info("No hay archivo");
                return back()->with('error', 'Missing image!');
            }
            
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetListadoArticulosByCodInterno(Request $request){
        try {
            $get = siab_articulos::select('siab_articulo.id','siab_articulo.NOMBRE','siab_articulo.UNIMEDBASE','siab_articulo.CODART_ONU',
            'siab_articulo.CODART','siab_articulo.CODART_BARR','auth_estados.descripcionEstado',
            'siab_articulo.UBICACION','siab_articulo.SECTOR','bodega.descripcionBodega','zona.descripcionZonas',
            'siab_articulo.CANTXENB','siab_articulo.ACT_FECVEN as idACT_FECVEN','siab_articulo.ACT_LOTE AS idACTLOTE',
            DB::raw("(CASE WHEN siab_articulo.ACT_FECVEN = 1 THEN 'Si' ELSE 'No' END) as ACT_FECVEN"),
            DB::raw("(CASE WHEN siab_articulo.ACT_LOTE = 1 THEN 'Si' ELSE 'No' END) as ACT_LOTE"),
            'siab_articulo.idEstado','siab_articulo.idBodega','siab_articulo.idZona','siab_articulo.NOMFAM1','siab_articulo.NOMFAM2',
            'siab_articulo.NOMFAM3','siab_articulo.NOMFAM4','siab_articulo.NOMFAM5'
            )
           ->leftjoin('auth_estados','siab_articulo.idEstado','=','auth_estados.id')
           ->leftjoin('bodega','siab_articulo.idBodega','=','bodega.id')
           ->leftjoin('zona','siab_articulo.idZona','=','zona.id')
           ->where('siab_articulo.CODART',$request->CODART)
           ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetListadoMedicamentosByCodInterno(Request $request){
        try {
            $get = siab_articulos::select('siab_articulo.id','siab_articulo.CODART_TRACK','siab_articulo.NOMBRE','siab_articulo.GENERICO',
            'siab_articulo.CAT_FARMACIA','siab_articulo.UNIMEDBASE','siab_articulo.CONCENTRACION',
            'siab_articulo.CODART_ONU','siab_articulo.CODART','siab_articulo.CODART_BARR','auth_estados.descripcionEstado',
            'siab_articulo.UBICACION','siab_articulo.SECTOR','siab_articulo.ZGEN','bodega.descripcionBodega','zona.descripcionZonas',
            'siab_articulo.LABORATORIO','siab_articulo.CANTXENB','siab_articulo.ACT_FECVEN as idACT_FECVEN','siab_articulo.ACT_LOTE AS idACTLOTE',
            DB::raw("(CASE WHEN siab_articulo.ACT_FECVEN = 1 THEN 'Si' ELSE 'No' END) as ACT_FECVEN"),
            DB::raw("(CASE WHEN siab_articulo.ACT_LOTE = 1 THEN 'Si' ELSE 'No' END) as ACT_LOTE"),
            'siab_articulo.idEstado','siab_articulo.idBodega','siab_articulo.idZona'
            )
           ->leftjoin('auth_estados','siab_articulo.idEstado','=','auth_estados.id')
           ->leftjoin('bodega','siab_articulo.idBodega','=','bodega.id')
           ->leftjoin('zona','siab_articulo.idZona','=','zona.id')
           ->where('siab_articulo.CODART',$request->CODART)
           ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostCodInsumoEconomato(Request $request){
        try {
            siab_articulos::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostValidarCodBarraMed(Request $request){
        try {
            $get =  siab_articulos::firstWhere('CODART_BARR', $request->CODART_BARR);
            if ($get === null) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetMedicamentos(){
        try {
            $get = siab_articulos::select('siab_articulo.id','siab_articulo.CODART_TRACK','siab_articulo.NOMBRE','siab_articulo.GENERICO',
            'siab_articulo.CAT_FARMACIA','siab_articulo.UNIMEDBASE','siab_articulo.CONCENTRACION',
            'siab_articulo.CODART_ONU','siab_articulo.CODART','siab_articulo.CODART_BARR','auth_estados.descripcionEstado',
            'siab_articulo.UBICACION','siab_articulo.SECTOR','siab_articulo.ZGEN','bodega.descripcionBodega','zona.descripcionZonas',
            'siab_articulo.LABORATORIO','siab_articulo.CANTXENB','siab_articulo.ACT_FECVEN as idACT_FECVEN','siab_articulo.ACT_LOTE AS idACTLOTE',
            DB::raw("(CASE WHEN siab_articulo.ACT_FECVEN = 1 THEN 'Si' ELSE 'No' END) as ACT_FECVEN"),
            DB::raw("(CASE WHEN siab_articulo.ACT_LOTE = 1 THEN 'Si' ELSE 'No' END) as ACT_LOTE"),
            'siab_articulo.idEstado','siab_articulo.idBodega','siab_articulo.idZona','siab_articulo.NOMARCH'
            )
           ->leftjoin('auth_estados','siab_articulo.idEstado','=','auth_estados.id')
           ->leftjoin('bodega','siab_articulo.idBodega','=','bodega.id')
           ->leftjoin('zona','siab_articulo.idZona','=','zona.id')
           ->where('siab_articulo.idBodega',1)
           ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetInsumoEconomato(){
        try {
            $get = siab_articulos::select('siab_articulo.id','siab_articulo.NOMBRE','siab_articulo.UNIMEDBASE','siab_articulo.CODART_ONU',
            'siab_articulo.CODART','siab_articulo.CODART_BARR','auth_estados.descripcionEstado',
            'siab_articulo.UBICACION','siab_articulo.SECTOR','bodega.descripcionBodega','zona.descripcionZonas',
            'siab_articulo.CANTXENB','siab_articulo.ACT_FECVEN as idACT_FECVEN','siab_articulo.ACT_LOTE AS idACTLOTE',
            DB::raw("(CASE WHEN siab_articulo.ACT_FECVEN = 1 THEN 'Si' ELSE 'No' END) as ACT_FECVEN"),
            DB::raw("(CASE WHEN siab_articulo.ACT_LOTE = 1 THEN 'Si' ELSE 'No' END) as ACT_LOTE"),
            'siab_articulo.idEstado','siab_articulo.idBodega','siab_articulo.idZona','siab_articulo.NOMFAM1','siab_articulo.NOMFAM2',
            'siab_articulo.NOMFAM3','siab_articulo.NOMFAM4','siab_articulo.NOMFAM5','siab_articulo.NOMARCH'
            )
           ->leftjoin('auth_estados','siab_articulo.idEstado','=','auth_estados.id')
           ->leftjoin('bodega','siab_articulo.idBodega','=','bodega.id')
           ->leftjoin('zona','siab_articulo.idZona','=','zona.id')
           ->where('siab_articulo.idBodega',2)
           ->orWhere('siab_articulo.idBodega',3)
           ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutMedicamentos(Request $request)
    {
        try {
            siab_articulos::where('id',$request->id)
            ->update(['CODART_BARR' => $request->CODART_BARR,'CODART_TRACK' => $request->CODART_TRACK,'CODART_ONU' => $request->CODART_ONU,
            'CODART' => $request->CODART,'NOMBRE' => $request->NOMBRE,'GENERICO' => $request->GENERICO,
            'CAT_FARMACIA' => $request->CAT_FARMACIA,'UNIMEDBASE' => $request->UNIMEDBASE,'CONCENTRACION' => $request->CONCENTRACION,
            'idEstado' => $request->idEstado,'ACT_FECVEN' => $request->ACT_FECVEN,'ACT_LOTE' => $request->ACT_LOTE,
            'LABORATORIO' => $request->LABORATORIO,'CANTXENB' => $request->CANTXENB,'idBodega' => $request->idBodega,
            'idZona' => $request->idZona,'SECTOR' => $request->SECTOR,'UBICACION' => $request->UBICACION,'ZGEN' => $request->ZGEN,
            'NOMARCH' => $request->NOMARCH]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutInsumoEconomato(Request $request)
    {
        try {
            siab_articulos::where('id',$request->id)
            ->update(['CODART_BARR' => $request->CODART_BARR,'CODART_ONU' => $request->CODART_ONU,'CODART' => $request->CODART,
            'NOMBRE' => $request->NOMBRE,'idEstado' => $request->idEstado,'ACT_FECVEN' => $request->ACT_FECVEN,
            'ACT_LOTE' => $request->ACT_LOTE,'idBodega' => $request->idBodega,'idZona' => $request->idZona,
            'SECTOR' => $request->SECTOR,'UBICACION' => $request->UBICACION,'NOMFAM1' => $request->NOMFAM1,
            'NOMFAM2' => $request->NOMFAM2,'NOMFAM3' => $request->NOMFAM3,'NOMFAM4' => $request->NOMFAM4,'NOMFAM5' => $request->NOMFAM5,
            'UNIMEDBASE' => $request->UNIMEDBASE,'NOMARCH' => $request->NOMARCH]);

            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetAllArticulos(){
        try {
            $get = siab_articulos::select('siab_articulo.id','siab_articulo.NOMBRE','siab_articulo.UNIMEDBASE','siab_articulo.CODART_ONU',
            'siab_articulo.CODART','siab_articulo.CODART_BARR','auth_estados.descripcionEstado',
            'siab_articulo.UBICACION','siab_articulo.SECTOR','bodega.descripcionBodega','zona.descripcionZonas',
            'siab_articulo.CANTXENB','siab_articulo.ACT_FECVEN as idACT_FECVEN','siab_articulo.ACT_LOTE AS idACTLOTE',
            DB::raw("(CASE WHEN siab_articulo.ACT_FECVEN = 1 THEN 'Si' ELSE 'No' END) as ACT_FECVEN"),
            DB::raw("(CASE WHEN siab_articulo.ACT_LOTE = 1 THEN 'Si' ELSE 'No' END) as ACT_LOTE"),
            'siab_articulo.idEstado','siab_articulo.idBodega','siab_articulo.idZona','siab_articulo.NOMFAM1','siab_articulo.NOMFAM2',
            'siab_articulo.NOMFAM3','siab_articulo.NOMFAM4','siab_articulo.NOMFAM5'
            )
           ->leftjoin('auth_estados','siab_articulo.idEstado','=','auth_estados.id')
           ->leftjoin('bodega','siab_articulo.idBodega','=','bodega.id')
           ->leftjoin('zona','siab_articulo.idZona','=','zona.id')
           ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

   
}
