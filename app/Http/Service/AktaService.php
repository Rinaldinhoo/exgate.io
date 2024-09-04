<?php

namespace App\Http\Service;

use GuzzleHttp\Client;
use App\Models\Gateway;

class AktaService
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
        // $requestNumber = $this->generateRequestNumber();
        // $dueDate = $this->generateDueDate();
        $suitpay = $this->getInfoGateway();
        $amountInt = $amount * 100;

        $response = $this->client->post($this->baseUrl . '/transactions', [
            'headers' => [
                'Authorization' => 'Basic c2tfbGl2ZV9ielVneUhTY0R1RGV6MzZaM0NDb3o3cms2WFUxd1NrOWE0TGJLOUpidHI6eA=='
            ],
            'json' => [
                'paymentMethod' => 'pix',
                'items' => [[
                    'title' => 'deposito exgate',
                    'unitPrice' => $amountInt,
                    'quantity' => 1,
                    'tangible' => false
                ]],
                'customer' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'document' => [
                        'number' => $this->gerarCPF(),
                        'type' => 'cpf'
                    ],
                ],
                'amount' => $amountInt,
                'postbackUrl' => $callbackUrl,
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    private function getBaseUrl()
    {
        return 'https://api.aktapay.com.br/v1';
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

    private function gerarDigito($cpf) {
        $soma = 0;
        $peso = strlen($cpf) + 1;
    
        for ($i = 0; $i < strlen($cpf); $i++) {
            $soma += $cpf[$i] * $peso--;
        }
    
        $digito = 11 - ($soma % 11);
        return $digito > 9 ? 0 : $digito;
    }
    
    private function gerarCPF() {
        $cpf = '';
        // Gerar os primeiros 9 dígitos aleatoriamente
        for ($i = 0; $i < 9; $i++) {
            $cpf .= rand(0, 9);
        }
    
        // Calcular o primeiro dígito verificador
        $cpf .= $this->gerarDigito($cpf);
    
        // Calcular o segundo dígito verificador
        $cpf .= $this->gerarDigito($cpf);
    
        return $cpf;
    }
}
