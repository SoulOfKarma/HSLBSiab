<?php

namespace App\Http\Controllers;

use App\DocumentacionAuthUsuarios;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use DB;
use Illuminate\Support\Facades\Log;
use IlluminateHttpRequest;
use AppModelsFileUpload;

class DocumentacionAuthUsuariosController extends Controller
{

    public function GetDocumentoAuthUsuario(Request $request){
        try {
            $get_all = DocumentacionAuthUsuarios::select("*")
            ->where("idAuthUsuario", $request->id)
            ->get();
            return $get_all;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostDocumentoAuthUsuario(Request $request)
    {
        try {
            if ($request->hasFile('avatar')) {
                // Si es así , almacenamos en la carpeta public/avatars
                // esta estará dentro de public/defaults/
               
               $url = $request->avatar->store('users/Documentacion');
               $DocumentacionAU = new DocumentacionAuthUsuarios;
               $DocumentacionAU->idAuthUsuario = $request->id;
               $DocumentacionAU->nombreDocAutogenerado = $url;
               $DocumentacionAU->save();
               $UltimoIDRegistrado = $DocumentacionAU->id;
               DocumentacionAuthUsuarios::where('id', $UltimoIDRegistrado)
                ->where('idAuthUsuario', $request->id)
                ->update(['nombreDocOriginal' => $request->nombreDocOriginal]);
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

    public function DestroyDocumentoAuthUsuario(Request $request){
        try {
            $res=DocumentacionAuthUsuarios::where('id',$request->id)->delete();
            if($res){
              return true;
            }
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
