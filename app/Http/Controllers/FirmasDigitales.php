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

class FirmasDigitales extends Controller
{
    public function TestFirmaDigita(){
        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMC41LjIzLjI0ODo5MDAwXC9hcGlcL2F1dGhcL2xvZ2luIiwiaWF0IjoxNjU3NzQyNjExLCJleHAiOjE2NTc3NDQ0MTEsIm5iZiI6MTY1Nzc0MjYxMSwianRpIjoidVZOdG55c3NyRmNiQUdleiIsInN1YiI6MSwicHJ2IjoiZWY4YmQyNTQxOTlhNGRmODExYmU2YzhkZDgzZTUxNWIxYmVjNjNkYyJ9.nqBM4uBeejPKvk_eZkPL1g-TppUaG3zMR_Z083XMcvI";
        $client = new \GuzzleHttp\Client();
        log::info($token);
        $res = $client->request('GET', 'http://10.5.23.248:9000/api/Despachos/GetDetallesDespachosAnulados',
        ['headers' => 
        [
            'Authorization' => "Bearer " . $token,        
            'Accept'        => 'application/json',
        ]
    ]);
        $resp = $res->getBody()->getContents();
        log::info($resp);
        return $resp;
    }

    public function TestFirmaDigital(Request $request){
        try{
                $getDet = recepcionDetalles::where('NUMINT',1)
                ->get();

                $getRec = recepciones::select('FOLIO','FECSYS','FECDES','RUTPRO','NOMPRO','NUMDOC','NUMORD','TIPDOC','FECDOC','DCTO',
                'OBS','CARGO','SUBTOTAL','AJUSTE','USUING','USUMOD','FECSYS','NUMINT','NUMRIB','TIPRECEPCION',
                DB::raw("SUBTOTAL as NETO"),DB::raw("ROUND((SUBTOTAL*0.19),2) as IVA"),DB::raw("ROUND((SUBTOTAL*0.19) + SUBTOTAL,2) as TOTAL"))
                ->where('NUMINT',1)
                ->get();
    //'data:application/pdf;base64,'.
                $pdf = App::make("dompdf.wrapper");
                $pdf->loadView('RecepcionFirma', compact ('getDet','getRec'));
                $pdf->setOptions(['isJavascriptEnabled' => true]);
                $pdf->setOptions(['isRemoteEnabled' => true]);
                $base = chunk_split(base64_encode($pdf->stream("RecepcionFirma.pdf", array("Attachment" => 0))));
                $hash = hash('sha256', $pdf->stream("RecepcionFirma.pdf", array("Attachment" => 0)));
                //Storage::disk('public')->put('file.pdf',base64_decode($base));
                $datos = json_encode([
                    'token' => $request->token,
                    'api_token_key' => $request->api_token_key,     
                    'files' => [
                        ["content-type" => "application/pdf",
                        "content" => $base,
                        "description" => "doc",
                        "checksum" => $hash,
                        "layout" => "<AgileSignerConfig>
                                        <Application id=\"THIS-CONFIG\">
                                        <pdfPassword/>
                                            <Signature>
                                                <Visible active=\"true\" layer2=\"false\" label=\"true\" pos=\"1\">
                                                    <llx>250</llx>
                                                    <lly>300</lly>
                                                    <urx>350</urx>
                                                    <ury>450</ury>
                                                    <page>LAST</page>
                                                    <image>BASE64</image>
                                                    <BASE64VALUE></BASE64VALUE>
                                                </Visible>
                                            </Signature>
                                        </Application>
                        </AgileSignerConfig>"]
                    ]
                ]);

            $client = new \GuzzleHttp\Client();
            $res = $client->post('https://api.firma.cert.digital.gob.cl/firma/v2/files/tickets',
            [
                'body' => $datos
            ]
            );
            $resp = $res->getBody()->getContents(); 
            
            log::info($resp);
            return $datos;
        }catch(\Throwable $th){
            log::info($th);
            return false;
        }

            
    }
}
