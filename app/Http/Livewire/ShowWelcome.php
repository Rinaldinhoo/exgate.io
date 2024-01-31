<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Api\BinanceController;



class ShowWelcome extends Component
{
    public $user;

    public $price;

    public function mount()
    {
        $this->user = Auth::user();

        $this->user->name = Str::limit($this->user->name, 15);

        $this->user->email = Str::limit($this->user->email, 15);

        $binanceController = new BinanceController();

        $priceResponse = $binanceController->lastPricing();

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

    public function render()
    {
        return view('livewire.show-welcome')->layout('layouts.app');
    }
}
