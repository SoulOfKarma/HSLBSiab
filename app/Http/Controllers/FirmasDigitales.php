<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
use App\recepcionDetalles;
use App\despachos;
use App\despachoDetalles;
use App\recepciones;
use App\FirmaRecepciones;
use App\FirmaDespachos;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Response;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use setasign\Fpdi\Fpdi;

class FirmasDigitales extends Controller
{
    //Registra Usuarios Firmantes Digitales Recepcion 
    public function PostUsuarioRecepcionFirma(Request $request){
        try {
            $datos = FirmaRecepciones::where('NUMINT',$request->NUMINT)->get();
            $contador = $datos->count();
            $validador = 1;
            if($contador == 0){
                FirmaRecepciones::create($request->all());
            }else{
                foreach ($datos as $p) {
                    if ($p->RUN == $request->RUN) {
                      $validador = 0;
                      break;
                    }
                  }
                if($validador == 1){
                    FirmaRecepciones::create($request->all());
                }else{
                    FirmaRecepciones::where('NUMINT',$request->NUMINT)->where('idPerfil',$request->idPerfil)
                ->update(['RUN' => $request->RUN]);
                }
            }

            //$datos = FirmaRecepciones::where('NUMINT',$request->NUMINT)->get();
            $datos = FirmaRecepciones::select('firma_recepciones.RUN','firma_recepciones.idPerfil','firma_recepciones.NUMINT',
            DB::raw("CONCAT(users.nombre_usuario,' ',users.apellido_usuario) as nombre"),'servicios.descripcionServicio')
            ->join('users','firma_recepciones.RUN','=',DB::raw('SUBSTRING(users.run, 1, 8)'))
            ->join('servicios','users.idServicio','=','servicios.id')
            ->where('NUMINT',$request->NUMINT)->get();

            return $datos;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    //Genera Documento PDF 
    public function GenerarDocumentoPDF($token,$api_token_key,$cont,$NUMINT){
        try{
                $getDet = recepcionDetalles::where('NUMINT',$NUMINT)
                ->get();

                $getRec = recepciones::select('FOLIO','FECSYS','FECDES','RUTPRO','NOMPRO','NUMDOC','NUMORD','TIPDOC','FECDOC','DCTO',
                'OBS','CARGO','SUBTOTAL','AJUSTE','USUING','USUMOD','FECSYS','NUMINT','NUMRIB','TIPRECEPCION',
                DB::raw("SUBTOTAL as NETO"),DB::raw("ROUND((SUBTOTAL*0.19),2) as IVA"),DB::raw("ROUND((SUBTOTAL*0.19) + SUBTOTAL,2) as TOTAL"))
                ->where('NUMINT',$NUMINT)
                ->get();

                $file = $cont;

                $pdf = App::make("dompdf.wrapper");
                $pdf->loadView('Recepcion', compact ('getDet','getRec'));
                $pdf->setOptions(['isJavascriptEnabled' => true]);
                $pdf->setOptions(['isRemoteEnabled' => true]);
                $base = chunk_split(base64_encode($pdf->stream($file, array("Attachment" => 0))));
                $hash = hash('sha256', $pdf->stream($file, array("Attachment" => 0)));
                //Storage::disk('public')->put('file.pdf',base64_decode($base));
                $datos = [
                    'token' => $token,
                    'api_token_key' => $api_token_key,
                    'files' => [
                        ["content-type" => "application/pdf",
                        "content" => $base,
                        "description" => "Recepcion",
                        "checksum" => $hash
                        ]
                    ]
                ];

            $client = new \GuzzleHttp\Client();
            $res = $client->post('https://api.firma.cert.digital.gob.cl/firma/v2/files/tickets',
            [   
                'body' => json_encode($datos)
            ]
            );
            $resp = json_decode($res->getBody()->getContents()); 
            
            $pdfFirmado = $resp->files[0]->content;

            Storage::disk('docFirmados')->put($file,base64_decode($pdfFirmado));

            return $file;
        }catch (RuntimeException $e) {
            // catches all kinds of RuntimeExceptions
            if ($e instanceof ClientException) {
                log::info($e);
                return false;
            } else if ($e instanceof RequestException) {
                log::info($e);
                return false;
            }
            return false;
        }
    }

    //Genera Firmas Digitales al Documento
    public function GenerarFirmasDigitales($token,$api_token_key,$cont){
        try{

            $file = $cont;
            $base = chunk_split(base64_encode(file_get_contents(Storage::disk('docFirmados')->path($cont))));
            $hash = hash('sha256', file_get_contents(Storage::disk('docFirmados')->path($cont)));
            $datos = [
                'token' => $token,
                'api_token_key' => $api_token_key,     
                'files' => [
                    ["content-type" => "application/pdf",
                    "content" => $base,
                    "description" => "Recepcion",
                    "checksum" => $hash
                    ]
                ]
            ]; 

            $client = new \GuzzleHttp\Client();
            $res = $client->post('https://api.firma.cert.digital.gob.cl/firma/v2/files/tickets',
            [   
                'body' => json_encode($datos)
            ]
            );
            $resp = json_decode($res->getBody()->getContents()); 
            
            $pdfFirmado = $resp->files[0]->content;

            Storage::disk('docFirmados')->put($file,base64_decode($pdfFirmado));

            return $file;
        }catch (RuntimeException $e) {
            // catches all kinds of RuntimeExceptions
            if ($e instanceof ClientException) {
                log::info($e);
                return false;
            } else if ($e instanceof RequestException) {
                log::info($e);
                return false;
            }
            return false;
        }

            
    }

    //Metodo General de los procesos de incrustacion de logo con firma y firma digital 
    public function FirmaDigitalArray(Request $request)
    {
        $this->GenerarDocumentoPDF($request->token,$request->api_token_key,$request->cont,$request->NUMINT);
        $outputFile = Storage::disk('docFirmados')->path($request->cont);
            if($request->codPerfil==1){
                $this->fillPDF(Storage::disk('docFirmados')->path($request->cont), $outputFile,$request->codPerfil,$request->descServicio,$request->nombreUsuario);
            }if($request->codPerfil1==2){
                $this->fillPDF(Storage::disk('docFirmados')->path($request->cont), $outputFile,$request->codPerfil1,$request->descServicio1,$request->nombreUsuario1);
            }if($request->codPerfil2==3){
                $this->fillPDF(Storage::disk('docFirmados')->path($request->cont), $outputFile,$request->codPerfil2,$request->descServicio2,$request->nombreUsuario2);
            }

            if($request->codPerfil==1){
                $this->GenerarFirmasDigitales($request->token,$request->api_token_key,$request->cont);
            }if($request->codPerfil1==2){
                $this->GenerarFirmasDigitales($request->token1,$request->api_token_key,$request->cont);
            }if($request->codPerfil2==3){
                $this->GenerarFirmasDigitales($request->token2,$request->api_token_key,$request->cont);
            }
            
        return $request->cont;
    }

    //Metodo que incrusta los logos de las firmas digitales
    public function fillPDF($file, $outputFile,$cod,$descServicio,$nombre)
    {
        $fpdi = new FPDI;
        // merger operations
        $count = $fpdi->setSourceFile($file);
        if($cod == 1){
            for ($i=1; $i<=$count; $i++) {
                $template   = $fpdi->importPage($i);
                $size       = $fpdi->getTemplateSize($template);
                $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
                $fpdi->useTemplate($template);
                $left = 35;
                $top = 264;
                $l = 35;
                $t = 268;
                $fpdi->Image(Storage::disk('docFirmados')->path('logof.png') , 15 ,259, 20 , 13,'PNG');
                $text = "Ricardo Arturo Soto Gomez";
                $fpdi->SetFont("helvetica", "", 7);
                $fpdi->SetTextColor(0,0,0);
                $fpdi->Text($left,$top,$nombre);
                $fpdi->Ln(1);
                $fpdi->Text($l,$t,$descServicio);
            }
        }else if($cod == 2){
        for ($i=1; $i<=$count; $i++) {
            $template   = $fpdi->importPage($i);
            $size       = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
            $fpdi->useTemplate($template);
            $left = 98;
            $top = 264;
            $l = 98;
            $t = 268;
            $fpdi->Image(Storage::disk('docFirmados')->path('logof.png') , 77 ,259, 20 , 13,'PNG');
            $text = nl2br("Ricardo Arturo Soto Gomez");
            $fpdi->SetFont("helvetica", "", 7);
            $fpdi->SetTextColor(0,0,0);
            $fpdi->Text($left,$top,$nombre);
            $fpdi->Ln(1);
            $fpdi->Text($l,$t,$descServicio);
        }
        }else if($cod == 3){
            for ($i=1; $i<=$count; $i++) {
                $template   = $fpdi->importPage($i);
                $size       = $fpdi->getTemplateSize($template);
                $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
                $fpdi->useTemplate($template);
                $left = 161;
                $top = 264;
                $l = 161;
                $t = 268;
                $fpdi->Image(Storage::disk('docFirmados')->path('logof.png') , 140 ,259, 20 , 13,'PNG');
                $text = nl2br("Ricardo Arturo Soto Gomez");
                $fpdi->SetFont("helvetica", "", 7);
                $fpdi->SetTextColor(0,0,0);
                $fpdi->Text($left,$top,$nombre);
                $fpdi->Ln(1);
                $fpdi->Text($l,$t,$descServicio);
            }
        }
        return $fpdi->Output($outputFile, 'F');
    }

    //Fin Firmas Recepcion

    //Firmas Despachos
    //Registra Usuarios Firmantes Digitales Despachos 
    public function PostUsuarioDespachosFirma(Request $request){
        try {
            $datos = FirmaDespachos::where('NUMINT',$request->NUMINT)->get();
            $contador = $datos->count();
            $validador = 1;
            if($contador == 0){
                FirmaDespachos::create($request->all());
            }else{
                foreach ($datos as $p) {
                    if ($p->RUN == $request->RUN) {
                      $validador = 0;
                      break;
                    }
                  }
                if($validador == 1){
                    FirmaDespachos::create($request->all());
                }else{
                    FirmaDespachos::where('NUMINT',$request->NUMINT)->where('idPerfil',$request->idPerfil)
                ->update(['RUN' => $request->RUN]);
                }
            }

            $datos = FirmaDespachos::select('firma_despachos.RUN','firma_despachos.idPerfil','firma_despachos.NUMINT',
            DB::raw("CONCAT(users.nombre_usuario,' ',users.apellido_usuario) as nombre"),'servicios.descripcionServicio')
            ->join('users','firma_despachos.RUN','=',DB::raw('SUBSTRING(users.run, 1, 8)'))
            ->join('servicios','users.idServicio','=','servicios.id')
            ->where('NUMINT',$request->NUMINT)->get();

            return $datos;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    //Genera Documento PDF 
    public function GenerarDocumentoDespachosPDF($token,$api_token_key,$cont,$NUMINT){
        try{
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

                $file = $cont;

                $pdf = App::make("dompdf.wrapper");
                $pdf->loadView('Despacho', compact ('getDet','getRec'));
                $pdf->setOptions(['isJavascriptEnabled' => true]);
                $pdf->setOptions(['isRemoteEnabled' => true]);
                $base = chunk_split(base64_encode($pdf->stream($file, array("Attachment" => 0))));
                $hash = hash('sha256', $pdf->stream($file, array("Attachment" => 0)));
                //Storage::disk('public')->put('file.pdf',base64_decode($base));
                $datos = [
                    'token' => $token,
                    'api_token_key' => $api_token_key,
                    'files' => [
                        ["content-type" => "application/pdf",
                        "content" => $base,
                        "description" => "Despacho",
                        "checksum" => $hash
                        ]
                    ]
                ];

            $client = new \GuzzleHttp\Client();
            $res = $client->post('https://api.firma.cert.digital.gob.cl/firma/v2/files/tickets',
            [   
                'body' => json_encode($datos)
            ]
            );
            $resp = json_decode($res->getBody()->getContents()); 
            
            $pdfFirmado = $resp->files[0]->content;

            Storage::disk('docFirmados')->put($file,base64_decode($pdfFirmado));

            return $file;
        }catch (RuntimeException $e) {
            // catches all kinds of RuntimeExceptions
            if ($e instanceof ClientException) {
                log::info($e);
                return false;
            } else if ($e instanceof RequestException) {
                log::info($e);
                return false;
            }
            return false;
        }
    }

    //Genera Firmas Digitales al Documento
    public function GenerarFirmasDespachosDigitales($token,$api_token_key,$cont){
        try{

            $file = $cont;
            $base = chunk_split(base64_encode(file_get_contents(Storage::disk('docFirmados')->path($cont))));
            $hash = hash('sha256', file_get_contents(Storage::disk('docFirmados')->path($cont)));
            $datos = [
                'token' => $token,
                'api_token_key' => $api_token_key,     
                'files' => [
                    ["content-type" => "application/pdf",
                    "content" => $base,
                    "description" => "Despacho",
                    "checksum" => $hash
                    ]
                ]
            ]; 

            $client = new \GuzzleHttp\Client();
            $res = $client->post('https://api.firma.cert.digital.gob.cl/firma/v2/files/tickets',
            [   
                'body' => json_encode($datos)
            ]
            );
            $resp = json_decode($res->getBody()->getContents()); 
            
            $pdfFirmado = $resp->files[0]->content;

            Storage::disk('docFirmados')->put($file,base64_decode($pdfFirmado));

            return $file;
        }catch (RuntimeException $e) {
            // catches all kinds of RuntimeExceptions
            if ($e instanceof ClientException) {
                log::info($e);
                return false;
            } else if ($e instanceof RequestException) {
                log::info($e);
                return false;
            }
            return false;
        }

            
    }

    //Metodo General de los procesos de incrustacion de logo con firma y firma digital 
    public function FirmaDigitalDespachoArray(Request $request)
    {
        $this->GenerarDocumentoDespachosPDF($request->token,$request->api_token_key,$request->cont,$request->NUMINT);
        $outputFile = Storage::disk('docFirmados')->path($request->cont);
            if($request->codPerfil==1){
                $this->fillDespachoPDF(Storage::disk('docFirmados')->path($request->cont), $outputFile,$request->codPerfil,$request->descServicio,$request->nombreUsuario);
            }if($request->codPerfil1==2){
                $this->fillDespachoPDF(Storage::disk('docFirmados')->path($request->cont), $outputFile,$request->codPerfil1,$request->descServicio1,$request->nombreUsuario1);
            }if($request->codPerfil2==3){
                $this->fillDespachoPDF(Storage::disk('docFirmados')->path($request->cont), $outputFile,$request->codPerfil2,$request->descServicio2,$request->nombreUsuario2);
            }

            if($request->codPerfil==1){
                $this->GenerarFirmasDespachosDigitales($request->token,$request->api_token_key,$request->cont);
            }if($request->codPerfil1==2){
                $this->GenerarFirmasDespachosDigitales($request->token1,$request->api_token_key,$request->cont);
            }if($request->codPerfil2==3){
                $this->GenerarFirmasDespachosDigitales($request->token2,$request->api_token_key,$request->cont);
            }
            
        return $request->cont;
    }

    //Metodo que incrusta los logos de las firmas digitales
    public function fillDespachoPDF($file, $outputFile,$cod,$descServicio,$nombre)
    {
        $fpdi = new FPDI;
        // merger operations
        $count = $fpdi->setSourceFile($file);
        if($cod == 1){
            for ($i=1; $i<=$count; $i++) {
                $template   = $fpdi->importPage($i);
                $size       = $fpdi->getTemplateSize($template);
                $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
                $fpdi->useTemplate($template);
                $left = 35;
                $top = 264;
                $l = 35;
                $t = 268;
                $fpdi->Image(Storage::disk('docFirmados')->path('logof.png') , 15 ,259, 20 , 13,'PNG');
                $text = "Ricardo Arturo Soto Gomez";
                $fpdi->SetFont("helvetica", "", 7);
                $fpdi->SetTextColor(0,0,0);
                $fpdi->Text($left,$top,$nombre);
                $fpdi->Ln(1);
                $fpdi->Text($l,$t,$descServicio);
            }
        }else if($cod == 2){
        for ($i=1; $i<=$count; $i++) {
            $template   = $fpdi->importPage($i);
            $size       = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
            $fpdi->useTemplate($template);
            $left = 98;
            $top = 264;
            $l = 98;
            $t = 268;
            $fpdi->Image(Storage::disk('docFirmados')->path('logof.png') , 77 ,259, 20 , 13,'PNG');
            $text = nl2br("Ricardo Arturo Soto Gomez");
            $fpdi->SetFont("helvetica", "", 7);
            $fpdi->SetTextColor(0,0,0);
            $fpdi->Text($left,$top,$nombre);
            $fpdi->Ln(1);
            $fpdi->Text($l,$t,$descServicio);
        }
        }else if($cod == 3){
            for ($i=1; $i<=$count; $i++) {
                $template   = $fpdi->importPage($i);
                $size       = $fpdi->getTemplateSize($template);
                $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
                $fpdi->useTemplate($template);
                $left = 161;
                $top = 264;
                $l = 161;
                $t = 268;
                $fpdi->Image(Storage::disk('docFirmados')->path('logof.png') , 140 ,259, 20 , 13,'PNG');
                $text = nl2br("Ricardo Arturo Soto Gomez");
                $fpdi->SetFont("helvetica", "", 7);
                $fpdi->SetTextColor(0,0,0);
                $fpdi->Text($left,$top,$nombre);
                $fpdi->Ln(1);
                $fpdi->Text($l,$t,$descServicio);
            }
        }
        return $fpdi->Output($outputFile, 'F');
    }
}
