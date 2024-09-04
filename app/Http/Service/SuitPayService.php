<?php

namespace App\Http\Service;

use GuzzleHttp\Client;
use App\Models\Gateway;

class SuitPayService
{
    private $client;
    private $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = $this->getBaseUrl();
    }

    public function generateQrPix($user, $callbackUrl, $amount)
    {
        $requestNumber = $this->generateRequestNumber();
        $dueDate = $this->generateDueDate();
        $suitpay = $this->getInfoGateway();

        $response = $this->client->post($this->baseUrl . '/gateway/request-qrcode', [
            'headers' => [
                'ci' => $suitpay->client_id,
                'cs' => $suitpay->client_secret,
            ],
            'json' => [
                'requestNumber' => $requestNumber,
                'dueDate' => $dueDate,
                'amount' => $amount,
                'callbackUrl' => $callbackUrl,
                'client' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'document' => '21111721033',
                ],
                // 'split' => [
                //     'username' => $user->username,
                //     'percentageSplit' => 20
                // ]
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    private function getBaseUrl()
    {
        return 'https://ws.suitpay.app/api/v1';
    }

    private function generateRequestNumber()
    {
        return str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
    }

    private function generateDueDate()
    {
        return date('Y-m-d', strtotime('+1 day'));
    }

    public function getInfoGateway()
    {
        return Gateway::first();
    }
}
