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
//use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Response;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class FirmasDigitales extends Controller
{
    public function TestFirmaDigital(Request $request){
        try{
                $getDet = recepcionDetalles::where('NUMINT',1)
                ->get();

                $getRec = recepciones::select('FOLIO','FECSYS','FECDES','RUTPRO','NOMPRO','NUMDOC','NUMORD','TIPDOC','FECDOC','DCTO',
                'OBS','CARGO','SUBTOTAL','AJUSTE','USUING','USUMOD','FECSYS','NUMINT','NUMRIB','TIPRECEPCION',
                DB::raw("SUBTOTAL as NETO"),DB::raw("ROUND((SUBTOTAL*0.19),2) as IVA"),DB::raw("ROUND((SUBTOTAL*0.19) + SUBTOTAL,2) as TOTAL"))
                ->where('NUMINT',1)
                ->get();

                $file = $request->cont;
                $link = $request->link;
                
                log::info($link);

                $pdf = App::make("dompdf.wrapper");
                $pdf->loadView('RecepcionFirma', compact ('getDet','getRec','link'));
                $pdf->setOptions(['isJavascriptEnabled' => true]);
                $pdf->setOptions(['isRemoteEnabled' => true]);
                $base = chunk_split(base64_encode($pdf->stream($file, array("Attachment" => 0))));
                $hash = hash('sha256', $pdf->stream($file, array("Attachment" => 0)));
                //Storage::disk('public')->put('file.pdf',base64_decode($base));
                $datos = [
                    'token' => $request->token,
                    'api_token_key' => $request->api_token_key,     
                    'files' => [
                        ["content-type" => "application/pdf",
                        "content" => $base,
                        "description" => "RecepcionFirma",
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

    public function TestMultiPdf(Request $request){
        try{

            $getDet = recepcionDetalles::where('NUMINT',1)
            ->get();

            $getRec = recepciones::select('FOLIO','FECSYS','FECDES','RUTPRO','NOMPRO','NUMDOC','NUMORD','TIPDOC','FECDOC','DCTO',
            'OBS','CARGO','SUBTOTAL','AJUSTE','USUING','USUMOD','FECSYS','NUMINT','NUMRIB','TIPRECEPCION',
            DB::raw("SUBTOTAL as NETO"),DB::raw("ROUND((SUBTOTAL*0.19),2) as IVA"),DB::raw("ROUND((SUBTOTAL*0.19) + SUBTOTAL,2) as TOTAL"))
            ->where('NUMINT',1)
            ->get();

            $file = $request->cont;
            $pdfitem = file_get_contents(Storage::disk('docFirmados')->path($file));
            $base = chunk_split(base64_encode($pdfitem));
            $hash = hash('sha256', $pdfitem);
            //Storage::disk('public')->put('file.pdf',base64_decode($base));
             $datos = [
                'token' => $request->token,
                'api_token_key' => $request->api_token_key,     
                'files' => [
                    ["content-type" => "application/pdf",
                    "content" => $base,
                    "description" => "RecepcionFirma",
                    "checksum" => $hash
                    ]
                ]
            ]; 

/*             $datos = [
                'token' => $request->token,
                'api_token_key' => $request->api_token_key,     
                'hashes' => [
                    [
                        "content-type" => "application/pdf",
                        "content" => $base
                    ]
                ]
            ]; */

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
}
