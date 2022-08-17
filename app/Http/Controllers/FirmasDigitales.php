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
            $base = chunk_split(base64_encode(file_get_contents(Storage::disk('docFirmados')->path('1.pdf'))));
            //$pdfitem = file_get_contents(Storage::disk('docFirmados')->path($file));
            //$base = chunk_split(base64_encode($pdfitem));
            //$hash = hash('sha256', $pdfitem);
            $hash = hash('sha256', file_get_contents(Storage::disk('docFirmados')->path('1.pdf')));
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

        /*  $datos = [
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

    public function IncrustarPDF(){
        try {
            //code...
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function process(Request $request)
    {
        // download sample file.
        //Storage::disk('local')->put('test.pdf', file_get_contents('http://www.africau.edu/images/default/sample.pdf'));
        //file_get_contents(Storage::disk('docFirmados')->path('1.pdf'));
        $outputFile = Storage::disk('docFirmados')->path('1.pdf');
        // fill data
        $this->fillPDF(Storage::disk('docFirmados')->path('1.pdf'), $outputFile);
        //output to browser
        //Storage::disk('docFirmados')->put('1.pdf',$outputFile);
        return response()->file($outputFile);
    }

    public function fillPDF($file, $outputFile)
    {
        $fpdi = new FPDI;
        // merger operations
        $count = $fpdi->setSourceFile($file);
        for ($i=1; $i<=$count; $i++) {
            $template   = $fpdi->importPage($i);
            $size       = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
            $fpdi->useTemplate($template);
            $left = 35;
            $top = 264;
            $fpdi->Image(Storage::disk('docFirmados')->path('logorr.png') , 77 ,259, 45 , 13,'PNG', 'http://10.5.23.248:9000/');
            $text = nl2br(".");
            $fpdi->SetFont("helvetica", "", 9);
            $fpdi->SetTextColor(0,0,0);
            $fpdi->Text($left,$top,$text);
        }
        return $fpdi->Output($outputFile, 'F');
    }
}
