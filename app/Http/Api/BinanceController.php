<?php

namespace App\Http\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class BinanceController extends Controller
{

    public function index()
    {
        $binance = $this->pricing();

        $velas = array_map(function ($vela) {
            return [

                'time_open' => $vela[0],
                'time_close' => $vela[6],
                'price_open' => $vela[1],
                'price_close' => $vela[4],
                'min' => $vela[3],
                'max' => $vela[2],
            ];
        }, $binance);


        return response()->json($velas);
    }

    private function pricing()
    {
        $url = 'https://api.binance.com/api/v3/klines';
        $parameters = [
            'symbol' => 'BTCUSDT',  
            'interval' => '5m',
            'limit' => '200'
        ];

        $headers = [
        'Accepts: application/json',
        ];
        $qs = http_build_query($parameters); // query string encode the parameters
        $request = "{$url}?{$qs}"; // create the request URL


        $curl = curl_init(); // Get cURL resource
        // Set cURL options
        curl_setopt_array($curl, array(
        CURLOPT_URL => $request,            // set the request URL
        CURLOPT_HTTPHEADER => $headers,     // set the headers 
        CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
        ));

        $response = curl_exec($curl); 

        $decoded = json_decode($response);

        return $decoded;
    }

    public function lastPricing()
    {
        $url = 'https://api.binance.com/api/v3/ticker/24hr';
        $parameters = [
            'symbol' => 'BTCUSDT',  
        ];

        $headers = [
        'Accepts: application/json',
        ];
        $qs = http_build_query($parameters); // query string encode the parameters
        $request = "{$url}?{$qs}"; // create the request URL


        $curl = curl_init(); // Get cURL resource
        // Set cURL options
        curl_setopt_array($curl, array(
        CURLOPT_URL => $request,            // set the request URL
        CURLOPT_HTTPHEADER => $headers,     // set the headers 
        CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
        ));

        $response = curl_exec($curl); 

        $decoded = json_decode($response);

        $askPrice = $decoded->askPrice;

        $arr = ['askPrice' => $askPrice];

        return response()->json($arr);
    }

    public function address()
    {
        
    }

    public function btcUsdtData()
    {
        $binance = $this->pricing();

        return response()->json($binance);
    }
}
