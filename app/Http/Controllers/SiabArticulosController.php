<?php

namespace App\Http\Controllers;

use App\siab_articulos;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class SiabArticulosController extends Controller
{
    public function PostArticuloMedicamento(Request $request){
        try {
            $id = siab_articulos::create($request->all())->id;
            return $id;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetArticuloMedicamento(){
        try {
            $get = siab_articulos::select('autorizadoretiro.RUN','autorizadoretiro.NOMBRES','autorizadoretiro.APELLIDOS',
            'servicios.descripcionServicio','auth_estados.descripcionEstado',
            DB::raw("DATE_FORMAT(autorizadoretiro.FECINI,'%d-%m-%Y') as FECINI"),
            'documentacion_auth_usuarios.nombreDocAutogenerado','autorizadoretiro.idServicio','autorizadoretiro.idEstado'
            )
           ->join('servicios','autorizadoretiro.idServicio','=','servicios.id')
           ->join('auth_estados','autorizadoretiro.idEstado','=','auth_estados.id')
           ->join('documentacion_auth_usuarios','autorizadoretiro.id','=','documentacion_auth_usuarios.idAuthUsuario')
           ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutArticuloMedicamento(Request $request)
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
