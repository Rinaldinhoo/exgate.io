<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Person;
use App\Models\Order;
use App\Models\TransactionHistory;
use App\Models\InternalTransfer;
use Illuminate\Support\Facades\Http;
use App\Models\Config;


class ShowTrocas extends Component
{

    public $successMessage;

    public $user;
    public $person;
    public $wallet;
    public $pricebuy;
    public $amountbuy;
    public $totalbuy;
    public $pricesell;
    public $amountsell;
    public $amountbuymarket;
    public $amountsellmarket;
    public $totalsell;
    public $value;
    public $address;
    public $taxa;
    public $historys;
    public $config;

    public $numberAccount;
    public $amontTranfer;

    protected $listeners = [
        'updatePrice' => 'setPrice',
        'atualizarAmountSell' => 'setAmountSell',
        'atualizarAmountBuy' => 'setAmountBuy',
    ];

    public function mount()
    {
        $this->config = Config::select('logomarca')->first();
        $this->user = Auth::user();
        $this->user->name = Str::limit($this->user->name, 15);
        $this->user->email = Str::limit($this->user->email, 15);
        $this->person = Person::where('user_id', $this->user->id)->first();
        $this->wallet = Wallet::where('person_id', $this->person->id)->first();
        $this->value = 0.00;
        $this->address = '';
        $this->taxa = 0.00;
        $this->numberAccount = '';
        $this->amontTransfer = 0.00;
        $this->successMessage = '';
        $this->ordersOpen = Order::where('type', 'limit')->where('person_id', $this->person->id)
            ->where('status','open')
            ->get();
        $this->ordersClose = Order::where('type', 'limit')->where('person_id', $this->person->id)
            ->where('status','closed')
            ->get();
        $this->ordersHistory = Order::where('type', 'limit')->where('person_id', $this->person->id)
            ->where('executed', false)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.show-trocas')->layout('layouts.trocas');
    }

    public function reload()
    {
        $this->wallet = Wallet::where('person_id', $this->person->id)->first();
        $this->ordersOpen = Order::where('type', 'limit')->where('person_id', $this->person->id)
            ->where('status','open')                    
            ->get();
        $this->ordersClose = Order::where('type', 'limit')->where('person_id', $this->person->id)
            ->where('status','closed')                    
            ->get();
        $this->ordersHistory = Order::where('type', 'limit')->where('person_id', $this->person->id)
            ->where('executed', false)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function setPrice($newPrice)
    {
        info("Price updated to: {$newPrice}");
        $this->totalbuy = $newPrice;
        $this->render();

    }

    public function setAmountSell($valor)
    {
        $this->amountsell = $valor;
    }
    
    public function setAmountBuy($valor)
    {
        $this->amountbuy = $valor;
    }

    public function orderScoreBuy()
    {

        // Busca a carteira do usuário
        $wallet = Wallet::where('person_id', $this->person->id)->first();
        
        // if($this->takeProft > 0 && $this->takeProft < $this->price * 1.01)
        // {
        //     $this->addError("orderError", "Ganho no take proft inferior a 1%.");

        //     return ["error" => "Preço inválido."];
        // }

        // if($this->stopLoss > $this->price)
        // {
        //     $this->addError("orderError", "Perda no stop loss inválido.");

        //     return ["error" => "Preço inválido."];
        // }

        // if($this->pricebuy <= 0)
        // {
        //     $this->addError("orderError", "Preço inválida.");

        //     return ["error" => "Preço inválida."];
        // }
    
        if($this->amountbuy <= 0)
        {
            $this->addError("orderError", "Quantidade inválida.");

            return ["error" => "Quantidade inválida."];
        }
        $this->amountbuy = str_replace([','], '.', $this->amountbuy);
        // $this->pricebuy = str_replace([','], '.', $this->pricebuy);

        if ($wallet->amountusdt <= $this->amountbuy) {
            $this->addError("orderError", "Saldo insuficiente para a compra.");

            return ["error" => "Quantidade inválida."];
        }
        $this->dispatchBrowserEvent('resetarCampos');
        
        // Calcula o valor mínimo necessário no saldo considerando a margem de 125 vezes
        // $maxRequiredBalance = $wallet->amountbuy * 125;
        // Calcula o valor mínimo necessário no saldo considerando a margem de 125 vezes
        // $maxRequiredAmount = floatval(str_replace(',', '.', $this->amountbuy)) * $this->price;

        // $this->totalOperation = $maxRequiredAmount * (1 + $this->cost); //OPERAÇÃO MAIS OS CUSTOS
        // $cost = $maxRequiredAmount * ($this->cost); // CUSTOS DA OPERAÇÃO

        // Verifica se o usuário tem saldo suficiente considerando a margem
        // if ($maxRequiredBalance < $maxRequiredAmount || $wallet->amountbuy <= 0) {
            
        //     $this->addError("orderError", "Saldo insuficiente para a margem de operação.");

        //     return ["error" => "Saldo insuficiente para a margem de operação."];
        // }

       // dd(floatval($this->amount));
        $response = Http::get('https://economia.awesomeapi.com.br/last/USD-BRL');
        if ($response->successful()) {
            $data = $response->json();
            $askPrice = $data['USDBRL']['ask'];
        }


        $order = Order::create([

            'person_id'     => $this->person->id ?? null,
            // 'price_open'    => floatval(str_replace(',', '.', $this->amountbuy))?? null,
            'price_open'    => floatval(str_replace(',', '.', $askPrice))?? null,
            'amount'        => floatval(str_replace(',', '.', $this->amountbuy * $askPrice))?? null,
            // 'total'         => $this->calculateTotalValue(floatval($this->pricebuy), floatval($this->amount)),
            'total'         => floatval($this->amountbuy),
            'status'        => 'open',
            // 'take_proft'    => floatval($this->takeProft) ?? null,
            // 'stop_loss'     => floatval($this->stopLoss) ?? null,
            'take_proft'    => 0,
            'stop_loss'     => 0,
            'direction'     => 'buy',
            'type'          => 'limit',
            'typecoin'      => 'brl'
        ]);

        // $updateAmount = $maxRequiredAmount / 125 + $cost;

        $wallet->update([
            'amountusdt' => $wallet->amountusdt - $this->amountbuy,
            'amountbrl' => $wallet->amountbrl + ($this->amountbuy * $askPrice),
        ]);

        $this->reload();

        return ["success" => "Deu certo"];
    }

    public function orderScoreBuyMarket()
    {

        // Busca a carteira do usuário
        $wallet = Wallet::where('person_id', $this->person->id)->first();

        // if($this->takeProft > 0 && $this->takeProft < $this->price * 1.01)
        // {
        //     $this->addError("orderError", "Ganho no take proft inferior a 1%.");

        //     return ["error" => "Preço inválido."];
        // }

        // if($this->stopLoss > $this->price)
        // {
        //     $this->addError("orderError", "Perda no stop loss inválido.");

        //     return ["error" => "Preço inválido."];
        // }

    
        if($this->amountbuymarket <= 0)
        {
            $this->addError("orderError", "Quantidade inválida.");

            return ["error" => "Quantidade inválida."];
        }

        // Calcula o valor mínimo necessário no saldo considerando a margem de 125 vezes
        // $maxRequiredBalance = $wallet->amountbuy * 125;
        // Calcula o valor mínimo necessário no saldo considerando a margem de 125 vezes
        // $maxRequiredAmount = floatval(str_replace(',', '.', $this->amountbuy)) * $this->price;

        // $this->totalOperation = $maxRequiredAmount * (1 + $this->cost); //OPERAÇÃO MAIS OS CUSTOS
        // $cost = $maxRequiredAmount * ($this->cost); // CUSTOS DA OPERAÇÃO

        // Verifica se o usuário tem saldo suficiente considerando a margem
        // if ($maxRequiredBalance < $maxRequiredAmount || $wallet->amountbuy <= 0) {
            
        //     $this->addError("orderError", "Saldo insuficiente para a margem de operação.");

        //     return ["error" => "Saldo insuficiente para a margem de operação."];
        // }

       // dd(floatval($this->amount));

        $binanceController = new BinanceController();
        $priceResponse = $binanceController->lastPricing();
        if ($priceResponse instanceof \Illuminate\Http\JsonResponse) {
            // Decodifica o JSON para um array PHP
            $data = $priceResponse->getData(true);
            $askPrice = $data['askPrice'];
        } else {
            // Se a resposta for um array ou outro tipo
            $askPrice = $priceResponse['askPrice'];
        }

        $order = Order::create([

            'person_id'     => $this->person->id ?? null,
            'price_open'    => floatval(str_replace(',', '.', $askPrice))?? null,
            'amount'        => floatval(str_replace(',', '.', $this->amountbuymarket))?? null,
            // 'total'         => $this->calculateTotalValue(floatval($this->pricebuy), floatval($this->amount)),
            'total'         => floatval($this->totalbuy),
            'status'        => 'open',
            // 'take_proft'    => floatval($this->takeProft) ?? null,
            // 'stop_loss'     => floatval($this->stopLoss) ?? null,
            'take_proft'    => 0,
            'stop_loss'     => 0,
            'type'          => 'Market',
            'direction'     => 'buy',
        ]);

        // $updateAmount = $maxRequiredAmount / 125 + $cost;

        // $wallet->upd¥¥¥ate([
        //     'amount' => $wallet->amount - $updateAmount
        // ]);

        $this->reload();

        return ["success" => "Deu certo"];
    }

    public function orderScoreSell()
    {

        // Busca a carteira do usuário
        $wallet = Wallet::where('person_id', $this->person->id)->first();

        // if($this->takeProft > 0 && $this->takeProft < $this->price * 1.01)
        // {
        //     $this->addError("orderError", "Ganho no take proft inferior a 1%.");

        //     return ["error" => "Preço inválido."];
        // }

        // if($this->stopLoss > $this->price)
        // {
        //     $this->addError("orderError", "Perda no stop loss inválido.");

        //     return ["error" => "Preço inválido."];
        // }

    
        if($this->amountsell <= 0)
        {
            $this->addError("orderError", "Quantidade inválida.");

            return ["error" => "Quantidade inválida."];
        }

        if ($wallet->amountbrl <= $this->amountsell) {
            $this->addError("orderError", "Saldo insuficiente para venda.");

            return ["error" => "Quantidade inválida."];
        }
        $this->dispatchBrowserEvent('resetarCampos');

        // Calcula o valor mínimo necessário no saldo considerando a margem de 125 vezes
        // $maxRequiredBalance = $wallet->amount * 125;
        // // Calcula o valor mínimo necessário no saldo considerando a margem de 125 vezes
        // $maxRequiredAmount = floatval(str_replace(',', '.', $this->amount)) * $this->price;

        // $this->totalOperation = $maxRequiredAmount * (1 + $this->cost); //OPERAÇÃO MAIS OS CUSTOS

        // $cost = $maxRequiredAmount * ($this->cost); // CUSTOS DA OPERAÇÃO

        // // Verifica se o usuário tem saldo suficiente considerando a margem
        // if ($maxRequiredBalance < $maxRequiredAmount || $wallet->amount <= 0) {
            
        //     $this->addError("orderError", "Saldo insuficiente para a margem de operação.");

        //     return ["error" => "Saldo insuficiente para a margem de operação."];
        // }
        $this->amountsell = str_replace([','], '.', $this->amountsell);
        // $this->pricesell = str_replace([','], '.', $this->pricesell);

        $response = Http::get('https://economia.awesomeapi.com.br/last/USD-BRL');
        if ($response->successful()) {
            $data = $response->json();
            $askPrice = $data['USDBRL']['ask'];
        }

        $amountsellNumerico = str_replace(',', '.', $this->amountsell);
        $amountsellNumerico = floatval($amountsellNumerico);
        $order = Order::create([

            'person_id'     => $this->person->id ?? null,
            'price_open'    => floatval(str_replace(',', '.', $askPrice))?? null,
            'amount'        => $amountsellNumerico ?? null,
            // 'total'         => $this->calculateT÷otalValue($this->price, $this->amount),
            'total'         => floatval($amountsellNumerico / $askPrice),
            'status'        => 'open',
            'take_proft'    => 0,
            'stop_loss'     => 0,
            // 'take_proft'    => floatval($this->takeProft) ?? null,
            // 'stop_loss'     => floatval($this->stopLoss) ?? null,
            'direction'     => 'sell',
            'type'          => 'limit'
        ]);

        // $updateAmount = $maxRequiredAmount / 125 + $cost;

        
        $wallet->update([
            'amountbrl' => $wallet->amountbrl - $amountsellNumerico,
            'amountusdt' => $wallet->amountusdt + ($amountsellNumerico / $askPrice)
        ]);

        $this->reload();


        return ["success" => "Deu certo"];
    }

    public function orderScoreSellMarket()
    {

        // Busca a carteira do usuário
        $wallet = Wallet::where('person_id', $this->person->id)->first();

        // if($this->takeProft > 0 && $this->takeProft < $this->price * 1.01)
        // {
        //     $this->addError("orderError", "Ganho no take proft inferior a 1%.");

        //     return ["error" => "Preço inválido."];
        // }

        // if($this->stopLoss > $this->price)
        // {
        //     $this->addError("orderError", "Perda no stop loss inválido.");

        //     return ["error" => "Preço inválido."];
        // }

    
        if($this->amountsellmarket <= 0)
        {
            $this->addError("orderError", "Quantidade inválida.");

            return ["error" => "Quantidade inválida."];
        }

        // Calcula o valor mínimo necessário no saldo considerando a margem de 125 vezes
        // $maxRequiredBalance = $wallet->amount * 125;
        // // Calcula o valor mínimo necessário no saldo considerando a margem de 125 vezes
        // $maxRequiredAmount = floatval(str_replace(',', '.', $this->amount)) * $this->price;

        // $this->totalOperation = $maxRequiredAmount * (1 + $this->cost); //OPERAÇÃO MAIS OS CUSTOS

        // $cost = $maxRequiredAmount * ($this->cost); // CUSTOS DA OPERAÇÃO

        // // Verifica se o usuário tem saldo suficiente considerando a margem
        // if ($maxRequiredBalance < $maxRequiredAmount || $wallet->amount <= 0) {
            
        //     $this->addError("orderError", "Saldo insuficiente para a margem de operação.");

        //     return ["error" => "Saldo insuficiente para a margem de operação."];
        // }
        $response = Http::get('https://economia.awesomeapi.com.br/last/USD-BRL');
        if ($response->successful()) {
            $data = $response->json();
            $askPrice = $data['USDBRL']['ask'];
        }

        $amountsellNumerico = str_replace(',', '.', $this->amountsellmarket);
        $amountsellNumerico = floatval($amountsellNumerico);
        $order = Order::create([

            'person_id'     => $this->person->id ?? null,
            'price_open'    => floatval(str_replace(',', '.', $askPrice))?? null,
            'amount'        => $amountsellNumerico ?? null,
            // 'total'         => $this->calculateT÷otalValue($this->price, $this->amount),
            'total'         => floatval($this->totalsell),
            'status'        => 'open',
            'take_proft'    => 0,
            'stop_loss'     => 0,
            // 'take_proft'    => floatval($this->takeProft) ?? null,
            // 'stop_loss'     => floatval($this->stopLoss) ?? null,
            'direction'     => 'sell',
            'type'          => 'Market'
        ]);

        // $updateAmount = $maxRequiredAmount / 125 + $cost;

        
        $wallet->update([
            'amountbrl' => $wallet->amountbrl - $amountsellNumerico,
            'amountusdt' => $wallet->amountusdt + ($amountsellNumerico / $ask),
        ]);

        $this->reload();


        return ["success" => "Deu certo"];
    }

    public function deleteOrder($orderId)
    {
        $wallet = Wallet::where('person_id', $this->person->id)->first();
        $order = Order::find($orderId);

        if ($order->direction == 'sell') {
            $wallet->update([
                'amount' => $wallet->amount + $order->amount
            ]);
        } elseif ($order->direction == 'buy') {
            $wallet->update([
                'amountusdt' => $wallet->amountusdt + $order->total
            ]);
        }

        $order->delete();

        $this->reload();

        return ["success" => "Deu certo"];
    }
}
