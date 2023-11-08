<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
class KurController extends Controller
{
    public function index()
    {
        $client = new Client();
        $response = $client->request('GET','https://api.exchangeratesapi.io/latest',[
            'query' => [
                'base' => 'USD',
                'symbols' => 'TRY'
            ]
        ]);

    $statusCode = $response->getStatusCode();
    $content = $response->getBody();

    if ($statusCode==200){ // 200 status durum kodu sitede her şeyin normal şekilde çalıştığını belirtir.
        $currencyData = json_decode($content,true);
        $usdToTry = $currencyData['rates']['TRY'] ?? null;

        if ($usdToTry){
            return view('curreny.index',['usdToTry'=>$usdToTry]);

        }else {
            return response()->json(['error' => 'ERROR'], 404);
        }

    }else{
        return response()->json(['error' => 'Unable to fetch currency data'], $statusCode);
    }
    }

    }


