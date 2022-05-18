<?php

namespace App\Http\Controllers;

use App\siab_articulos;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

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

    public function PostCodInsumoEconomato(Request $request){
        try {
            siab_articulos::create($request->all());
            return true;
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
            'siab_articulo.idEstado','siab_articulo.idBodega','siab_articulo.idZona'
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
            'siab_articulo.CANTXENB','descripcion_familia.descripcionFamilia as desFam1','descripcion_familia01.descripcionFamilia as desFam2',
            'descripcion_familia02.descripcionFamilia as desFam3','descripcion_familia03.descripcionFamilia as desFam4',
            'descripcion_familia04.descripcionFamilia as desFam5',
            'siab_articulo.ACT_FECVEN as idACT_FECVEN','siab_articulo.ACT_LOTE AS idACTLOTE',
            DB::raw("(CASE WHEN siab_articulo.ACT_FECVEN = 1 THEN 'Si' ELSE 'No' END) as ACT_FECVEN"),
            DB::raw("(CASE WHEN siab_articulo.ACT_LOTE = 1 THEN 'Si' ELSE 'No' END) as ACT_LOTE"),
            'siab_articulo.idEstado','siab_articulo.idBodega','siab_articulo.idZona','siab_articulo.idFam1','siab_articulo.idFam2',
            'siab_articulo.idFam3','siab_articulo.idFam4','siab_articulo.idFam5'
            )
           ->join('auth_estados','siab_articulo.idEstado','=','auth_estados.id')
           ->join('bodega','siab_articulo.idBodega','=','bodega.id')
           ->join('zona','siab_articulo.idZona','=','zona.id')
           ->join('descripcion_familia','siab_articulo.idFam1','=','descripcion_familia.id')
           ->leftjoin('descripcion_familia01','siab_articulo.idFam2','=','descripcion_familia01.id')
           ->leftjoin('descripcion_familia02','siab_articulo.idFam3','=','descripcion_familia02.id')
           ->leftjoin('descripcion_familia03','siab_articulo.idFam4','=','descripcion_familia03.id')
           ->leftjoin('descripcion_familia04','siab_articulo.idFam5','=','descripcion_familia04.id')
           ->where('siab_articulo.idBodega',2)
           ->orwhere('siab_articulo.idBodega',3)
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
            'idZona' => $request->idZona,'SECTOR' => $request->SECTOR,'UBICACION' => $request->UBICACION,'ZGEN' => $request->ZGEN]);
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
            'SECTOR' => $request->SECTOR,'UBICACION' => $request->UBICACION,'idFam1' => $request->idFam1,
            'idFam2' => $request->idFam2,'idFam3' => $request->idFam3,'idFam4' => $request->idFam4,'idFam5' => $request->idFam5,
            'UNIMEDBASE' => $request->UNIMEDBASE]);

            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
