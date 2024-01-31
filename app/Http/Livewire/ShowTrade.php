<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;

use App\Models\Person;

use App\Models\Wallet;

use App\Models\Order;

use App\Models\Pricing;

use Illuminate\Support\Str;

use App\Http\Api\BinanceController;

class ShowTrade extends Component
{
    public $user;
    public $person;
    public $orders;
    public $ordersOpen;
    public $ordersClose;
    public $ordersHistory;
    public $wallet;
    public $price;
    public $amount;
    public $total;
    public $takeProft;
    public $stopLoss;
    public $priceBuy;
    public $priceSell;
    public $cost;
    public $totalOperation;


    protected $listeners = [
        'updatePrice' => 'setPrice', 
        'updateAmount' => 'setAmount',
        'updatePriceBuySell' => 'setPriceBuySell'
    ];


    public function mount()
    {
        $this->user = Auth::user();
        $this->user->name = Str::limit($this->user->name, 15);
        $this->user->email = Str::limit($this->user->email, 15);
        $this->person = Person::where('user_id', $this->user->id)->first();
        $this->wallet = Wallet::where('person_id', $this->person->id)->first();
        $this->amount = 0;
        $this->ordersBook = Order::paginate(10)->items();
        $this->ordersOpen = Order::where('person_id', $this->person->id)
        ->where('status','open')                    
        ->get();
        $this->ordersClose = Order::where('person_id', $this->person->id)
        ->where('status','closed')                    
        ->get();
        
        $this->cost = 0.001;

        $this->ordersHistory = Order::where('person_id', $this->person->id)->paginate(25)->items();

        $latestPricing = Pricing::orderBy('id', 'desc')->first();

        if ($latestPricing) {
            $this->price = $latestPricing->price_open;
        } else {
            // Handle the case where no pricing record exists
            $this->price_open = 0; // or some default value, or trigger an exception, etc.
        }

        $this->total = 0;
        $this->totalOperation = 0.00;
        $this->priceBuy = 0.00;
        $this->priceSell = 0.00;
    
    }
    
    public function render()
    {
        return view('livewire.show-trade')->layout('layouts.trade');
    }

    public function reload()
    {
        $this->total = 0.00;
        $this->priceBuy = 0.00;
        $this->priceSell = 0.00;
        $this->amount = 0;
        $this->ordersBook = Order::where('status','open')->paginate(10)->items();
        $this->ordersOpen = Order::where('person_id', $this->person->id)
        ->where('status','open')                    
        ->get();
        $this->ordersClose = Order::where('person_id', $this->person->id)
        ->where('status','close')                    
        ->get();
        $this->wallet = Wallet::where('person_id', $this->person->id)->first();
        $this->totalOperation = 0.00;
    }

    function calculateTotalValue($inputBitcoinPrice, $inputBitcoinPurchased) {

        $bitcoinPrice = floatval(str_replace(',', '.', $inputBitcoinPrice));

        $bitcoinAmount = floatval(str_replace(',', '.', $inputBitcoinPurchased));

        return floatval($bitcoinPrice) * floatval($bitcoinAmount);
    }

    public function orderScoreBuy()
    {

        // Busca a carteira do usuário
        $wallet = Wallet::where('person_id', $this->person->id)->first();

        if($this->takeProft > 0 && $this->takeProft < $this->price * 1.01)
        {
            $this->addError("orderError", "Ganho no take proft inferior a 1%.");

            return ["error" => "Preço inválido."];
        }

        if($this->stopLoss > $this->price)
        {
            $this->addError("orderError", "Perda no stop loss inválido.");

            return ["error" => "Preço inválido."];
        }

    
        if($this->amount <= 0)
        {
            $this->addError("orderError", "Quantidade inválida.");

            return ["error" => "Quantidade inválida."];
        }

        // Calcula o valor mínimo necessário no saldo considerando a margem de 125 vezes
        $maxRequiredBalance = $wallet->amount * 125;
        // Calcula o valor mínimo necessário no saldo considerando a margem de 125 vezes
        $maxRequiredAmount = floatval(str_replace(',', '.', $this->amount)) * $this->price;

        $this->totalOperation = $maxRequiredAmount * (1 + $this->cost); //OPERAÇÃO MAIS OS CUSTOS
        $cost = $maxRequiredAmount * ($this->cost); // CUSTOS DA OPERAÇÃO

        // Verifica se o usuário tem saldo suficiente considerando a margem
        if ($maxRequiredBalance < $maxRequiredAmount || $wallet->amount <= 0) {
            
            $this->addError("orderError", "Saldo insuficiente para a margem de operação.");

            return ["error" => "Saldo insuficiente para a margem de operação."];
        }

       // dd(floatval($this->amount));


        $order = Order::create([

            'person_id'     => $this->person->id ?? null,
            'price_open'    => floatval(str_replace(',', '.', $this->price))?? null,
            'amount'        => floatval(str_replace(',', '.', $this->amount))?? null,
            'total'         => $this->calculateTotalValue(floatval($this->price), floatval($this->amount)),
            'status'        => 'open',
            'take_proft'    => floatval($this->takeProft) ?? null,
            'stop_loss'     => floatval($this->stopLoss) ?? null,
            'direction'     => 'buy'
        ]);

        $updateAmount = $maxRequiredAmount / 125 + $cost;

        $wallet->update([
            'amount' => $wallet->amount - $updateAmount
        ]);

        $this->reload();

        return ["success" => "Deu certo"];
    }

    public function orderScoreSell()
    {

        // Busca a carteira do usuário
        $wallet = Wallet::where('person_id', $this->person->id)->first();

        

        if($this->takeProft > 0 && $this->takeProft < $this->price * 1.01)
        {
            $this->addError("orderError", "Ganho no take proft inferior a 1%.");

            return ["error" => "Preço inválido."];
        }

        if($this->stopLoss > $this->price)
        {
            $this->addError("orderError", "Perda no stop loss inválido.");

            return ["error" => "Preço inválido."];
        }

    
        if($this->amount <= 0)
        {
            $this->addError("orderError", "Quantidade inválida.");

            return ["error" => "Quantidade inválida."];
        }

        // Calcula o valor mínimo necessário no saldo considerando a margem de 125 vezes
        $maxRequiredBalance = $wallet->amount * 125;
        // Calcula o valor mínimo necessário no saldo considerando a margem de 125 vezes
        $maxRequiredAmount = floatval(str_replace(',', '.', $this->amount)) * $this->price;

        $this->totalOperation = $maxRequiredAmount * (1 + $this->cost); //OPERAÇÃO MAIS OS CUSTOS

        $cost = $maxRequiredAmount * ($this->cost); // CUSTOS DA OPERAÇÃO

        // Verifica se o usuário tem saldo suficiente considerando a margem
        if ($maxRequiredBalance < $maxRequiredAmount || $wallet->amount <= 0) {
            
            $this->addError("orderError", "Saldo insuficiente para a margem de operação.");

            return ["error" => "Saldo insuficiente para a margem de operação."];
        }

        $order = Order::create([

            'person_id'     => $this->person->id ?? null,
            'price_open'         => floatval(str_replace(',', '.', $this->price))?? null,
            'amount'        => floatval(str_replace(',', '.', $this->amount))?? null,
            'total'         => $this->calculateTotalValue($this->price, $this->amount),
            'status'        => 'open',
            'take_proft'    => floatval($this->takeProft) ?? null,
            'stop_loss'     => floatval($this->stopLoss) ?? null,
            'direction'     => 'sell'
        ]);

        $updateAmount = $maxRequiredAmount / 125 + $cost;

        $wallet->update([
            'amount' => $wallet->amount - $updateAmount
        ]);

        $this->reload();


        return ["success" => "Deu certo"];
    }
 
    public function setPrice($newPrice)
    {
        info("Price updated to: {$newPrice}");
        $this->price = $newPrice;
        $this->render();

    } 
 
    public function setAmount($newAmount)
    {
        info("Price updated to: {$newAmount}");
        $this->amount = $newAmount;
        $this->render();

    }   

    public function setPriceBuySell($value)
    {

        $buy = is_numeric($value) ? floatval($value) : 0;
        $sell = is_numeric($value) ? floatval($value) : 0;

        if ($value != 0 && $this->price != 0) {
            $newAmount = $value / $this->price;
        } else {
            // Defina $newAmount para um valor padrão ou realize outra ação
            $newAmount = 0; // ou qualquer outro valor ou ação conforme necessário
        }
        
        info("Price updated to: {$newAmount}");
        $this->amount = $newAmount;
        $this->render();

        $this->priceBuy = $buy;
        $this->priceSell = $sell;
        $this->totalOperation = $buy + $buy * $this->cost;
    }

    public function updatedAmount($value)
    {
      
        $amount = is_numeric($value) ? floatval($value) : 0;
   
        $this->priceBuy = $amount * $this->price;
        $this->priceSell = $amount * $this->price;

        $this->totalOperation = $this->priceBuy +  $this->priceBuy * $this->cost;
    }

    public function orderClose($orderId)
    {
        $order = Order::find($orderId);
    
        $binanceController = new BinanceController();

        $priceResponse = $binanceController->lastPricing();

        // Se a resposta for um objeto de resposta JSON do Laravel
        if ($priceResponse instanceof \Illuminate\Http\JsonResponse) {
            // Decodifica o JSON para um array PHP
            $data = $priceResponse->getData(true);
            $askPrice = $data['askPrice'];
        } else {
            // Se a resposta for um array ou outro tipo
            $askPrice = $priceResponse['askPrice'];
        }

        if($order->direction === 'buy')
        {
            $gainLoss = (floatval($askPrice) - floatval($order->price_open)) * $order->amount;
        }else{
            $gainLoss = (floatval($order->price_open) - floatval($askPrice)) * $order->amount;
        }

        // Atualizar a ordem
        $order->update([
            'status'        => 'closed',
            'gain_loss'     => $gainLoss,
            'price_closed'   => floatval($askPrice)
        ]);

        $wallet = Wallet::where('person_id', '=', $order->person_id)->first();

       // dd($wallet->amount + $gainLoss);

        $wallet->update([
            'amount' => $wallet->amount + floatval($gainLoss)
        ]);
    
        $this->reload();
    }
    


    


    
}
