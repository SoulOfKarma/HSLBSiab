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
use setasign\Fpdi\Fpdi;

class FirmasDigitales extends Controller
{
    public function TestFirmaDigital($token,$api_token_key,$cont){
        try{
                $getDet = recepcionDetalles::where('NUMINT',1)
                ->get();

                $getRec = recepciones::select('FOLIO','FECSYS','FECDES','RUTPRO','NOMPRO','NUMDOC','NUMORD','TIPDOC','FECDOC','DCTO',
                'OBS','CARGO','SUBTOTAL','AJUSTE','USUING','USUMOD','FECSYS','NUMINT','NUMRIB','TIPRECEPCION',
                DB::raw("SUBTOTAL as NETO"),DB::raw("ROUND((SUBTOTAL*0.19),2) as IVA"),DB::raw("ROUND((SUBTOTAL*0.19) + SUBTOTAL,2) as TOTAL"))
                ->where('NUMINT',1)
                ->get();

                $file = $cont;

                $pdf = App::make("dompdf.wrapper");
                $pdf->loadView('RecepcionFirma', compact ('getDet','getRec'));
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

    public function TestMultiPdf($token,$api_token_key,$cont){
        try{

            $file = $cont;
            $base = chunk_split(base64_encode(file_get_contents(Storage::disk('docFirmados')->path('1.pdf'))));
            $hash = hash('sha256', file_get_contents(Storage::disk('docFirmados')->path('1.pdf')));
            $datos = [
                'token' => $token,
                'api_token_key' => $api_token_key,     
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

    public function process(Request $request)
    {
        $this->TestFirmaDigital($request->token,$request->api_token_key,$request->cont);
        $outputFile = Storage::disk('docFirmados')->path('1.pdf');
        $this->fillPDF(Storage::disk('docFirmados')->path('1.pdf'), $outputFile,$request->codPerfil);
        $this->TestMultiPdf($request->token,$request->api_token_key,$request->cont);
        return $request->cont;
    }

    public function fillPDF($file, $outputFile,$cod)
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
                $fpdi->Image(Storage::disk('docFirmados')->path('logorr.png') , 15 ,259, 45 , 13,'PNG');
                $text = nl2br(".");
                $fpdi->SetFont("helvetica", "", 9);
                $fpdi->SetTextColor(0,0,0);
                $fpdi->Text($left,$top,$text);
            }
        }else if($cod == 2){
        for ($i=1; $i<=$count; $i++) {
            $template   = $fpdi->importPage($i);
            $size       = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
            $fpdi->useTemplate($template);
            $left = 35;
            $top = 264;
            $fpdi->Image(Storage::disk('docFirmados')->path('logorr.png') , 77 ,259, 45 , 13,'PNG');
            $text = nl2br(".");
            $fpdi->SetFont("helvetica", "", 9);
            $fpdi->SetTextColor(0,0,0);
            $fpdi->Text($left,$top,$text);
        }
        }else if($cod == 3){
            for ($i=1; $i<=$count; $i++) {
                $template   = $fpdi->importPage($i);
                $size       = $fpdi->getTemplateSize($template);
                $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
                $fpdi->useTemplate($template);
                $left = 35;
                $top = 264;
                $fpdi->Image(Storage::disk('docFirmados')->path('logorr.png') , 140 ,259, 45 , 13,'PNG');
                $text = nl2br(".");
                $fpdi->SetFont("helvetica", "", 9);
                $fpdi->SetTextColor(0,0,0);
                $fpdi->Text($left,$top,$text);
            }
        }
        return $fpdi->Output($outputFile, 'F');
    }
}
