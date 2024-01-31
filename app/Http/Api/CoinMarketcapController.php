<?php

namespace App\Http\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CoinMarketcapController extends Controller
{
    public function index()
    {
        $url = 'https://pro-api.coinmarketcap.com/v2/cryptocurrency/quotes/latest';
        $parameters = [
            'id' => '1',  
            'convert' => 'USDT'
        ];

        $headers = [
        'Accepts: application/json',
        'X-CMC_PRO_API_KEY: 79ac24a8-e2eb-4473-8c3f-f664bd0cf081'
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

        curl_close($curl);

        $data = new \stdClass();

        $data->code         = $decoded->data->{'1'}->id;
        $data->symbol       = $decoded->data->{'1'}->symbol;
        $data->name         = $decoded->data->{'1'}->name;
        $data->price        = $decoded->data->{'1'}->quote->USDT->price;
        $data->last_updated = $decoded->data->{'1'}->quote->USDT->last_updated;

        return $data;
    }
}
