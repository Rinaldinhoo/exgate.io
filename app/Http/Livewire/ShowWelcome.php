<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Api\BinanceController;
use App\Models\Person;
use App\Models\Config;
use App\Models\Wallet;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifiedEmail;

class ShowWelcome extends Component
{
    public $user;

    public $price;
    public $priceBrl;
    public $pctChange;
    public $pctChangeUsd;
    public $config;

    public function mount()
    {
        $this->user = Auth::user();
        $this->config = Config::select('logomarca')->first();
        $this->person = Person::where('user_id', $this->user->id)
            ->first();
        $this->wallet = Wallet::where('person_id', $this->person->id)
            ->first();
        $this->ordersHistory = Order::where('person_id', $this->person->id)->where('executed', false)->orderBy('created_at', 'desc')->limit(10)->get();

        $this->user->name = Str::limit($this->user->name, 15);

        $this->user->email = Str::limit($this->user->email, 15);

        $binanceController = new BinanceController();

        $priceResponse = $binanceController->lastPricing();

        $response = Http::get('https://economia.awesomeapi.com.br/last/USD-BRL');
        if ($response->successful()) {
            $data = $response->json();
            $this->priceBrl = $data['USDBRL']['ask'];
            $this->pctChange = $data['USDBRL']['pctChange'];
        }
        $response = Http::get('https://economia.awesomeapi.com.br/last/BTC-USD');
        if ($response->successful()) {
            $data = $response->json();
            $this->pctChangeUsd = $data['BTCUSD']['pctChange'];
        }

        // Se a resposta for um objeto de resposta JSON do Laravel
        if ($priceResponse instanceof \Illuminate\Http\JsonResponse) {
            // Decodifica o JSON para um array PHP
            $data = $priceResponse->getData(true);
            $this->price = $data['askPrice'];
        } else {
            // Se a resposta for um array ou outro tipo
            $this->price = $priceResponse['askPrice'];
        }
    }

    public function sendIdentidade()
    {
        return redirect('https://app.exgate.io/identification');
    }

    public function sendSecurity()
    {
        return redirect('https://app.exgate.io/security');
    }

    public function sendEmail()
    {
        $token = $this->generateRandomToken();
        $verificationLink = "https://app.exgate.io/verified?token=".$token;
        $this->user->update([
            'tokenverified' => $token
        ]);
        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'title' => 'Email Enviado',
            'text' => 'O email foi enviado com sucesso. Por favor, verifique sua caixa de entrada ou a pasta de spam/lixeira.',
        ]);
        try {
            Mail::to($this->user->email)->send(new VerifiedEmail($verificationLink));
        } catch (Exception $e) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'title' => 'Erro!',
                'text' => 'Não foi possível enviar o e-mail. Por favor, entre em contato com o suporte.',
            ]);
        }
        // $this->dispatchBrowserEvent('swal:modal', [
        //     'type' => 'success',
        //     'title' => 'Email Enviado',
        //     'text' => 'O email foi enviado com sucesso. Por favor, verifique sua caixa de entrada ou a pasta de spam/lixeira.',
        // ]);

    }

    public function render()
    {
        return view('livewire.show-welcome')->layout('layouts.app');
    }

    private function generateRandomToken($length = 32) {
        // Caracteres permitidos para o token
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    
        // Calcula o tamanho do conjunto de caracteres
        $charactersLength = strlen($characters);
    
        // Inicializa a variável para armazenar o token
        $token = '';
    
        // Gera o token aleatório
        for ($i = 0; $i < $length; $i++) {
            $token .= $characters[rand(0, $charactersLength - 1)];
        }
    
        return $token;
    }
}
