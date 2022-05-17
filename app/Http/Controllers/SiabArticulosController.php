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
            $id = siab_articulos::create($request->all())->id;
            return $id;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetMedicamentos(){
        try {
            $get = siab_articulos::select('siab_articulo.CODART_TRACK','siab_articulo.NOMBRE','siab_articulo.GENERICO',
            'siab_articulo.CAT_FARMACIA','siab_articulo.UNIMEDBASE','siab_articulo.CONCENTRACION',
            'siab_articulo.CODART_ONU','siab_articulo.CODART','siab_articulo.CODART_BARR','auth_estados.descripcionEstado',
            'siab_articulo.UBICACION','siab_articulo.SECTOR','siab_articulo.ZGEN','bodega.descripcionBodega','zona.descripcionZonas',
            'siab_articulo.LABORATORIO','siab_articulo.CANTXENB',
            DB::raw("(CASE WHEN siab_articulo.ACT_FECVEN = 1 THEN 'Si' ELSE 'No' END) as ACT_FECVEN"),
            DB::raw("(CASE WHEN siab_articulo.ACT_LOTE = 1 THEN 'Si' ELSE 'No' END) as ACT_LOTE"),
            )
           ->join('auth_estados','siab_articulo.idEstado','=','auth_estados.id')
           ->join('bodega','siab_articulo.idBodega','=','bodega.id')
           ->join('zona','siab_articulo.idZona','=','zona.id')
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
            ->update(['RUN' => $request->RUN,'NOMBRES' => $request->NOMBRES,'APELLIDOS' => $request->APELLIDOS,'FECINI' => $request->FECINI,
            'FECFIN' => $request->FECFIN,'idEstado' => $request->idEstado,'idServicio' => $request->idServicio]);

            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
