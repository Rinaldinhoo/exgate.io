<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;

use App\Models\Person;

use App\Models\Wallet;
use App\Models\User;

use App\Models\Order;

use App\Models\Config;

use App\Models\Pricing;

use Illuminate\Support\Str;

use App\Http\Api\BinanceController;

class ShowTrade extends Component
{
    public $user;
    public $person;
    public $orders;
    public $ordersOpen;
    public $config;
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
    public $calcMargem;
    public $margem;
    public $typeCoin = 'BTC';   

    protected $listeners = [
        'updatePrice' => 'setPrice', 
        'updateAmount' => 'setAmount',
        'updatePriceBuySell' => 'setPriceBuySell',
        'updatecoin' => 'setTypecoin',
    ];


    public function mount()
    {
        $this->user = Auth::user();
        $this->config = Config::select(['logomarca', 'margem'])->first();
        $this->margem = $this->config->margem;
        $this->user->name = Str::limit($this->user->name, 15);
        $this->user->email = Str::limit($this->user->email, 15);
        $this->person = Person::where('user_id', $this->user->id)->first();
        $this->wallet = Wallet::where('person_id', $this->person->id)->first();
        $this->amount = 0;
        $this->ordersBook = Order::where('type', 'future')->orderBy('created_at', 'desc')->paginate(10)->items();
        $this->ordersOpen = Order::where('type', 'future')->where('person_id', $this->person->id)
        ->where('status','open')
        ->orderBy('created_at', 'desc')
        ->get();
        $this->ordersClose = Order::where('type', 'future')->where('person_id', $this->person->id)
        ->where('status','closed')
        ->orderBy('created_at', 'desc')
        ->get();
        
        $this->cost = 0.001;
        // if ($this->wallet->amountmargem > 0 && $this->wallet->isoperated == true) {
        if ($this->wallet->isoperated == true) {
            $this->calcMargem = $this->wallet->amountmargem;
        } else {
            $this->calcMargem = ($this->wallet->amountusdt * ($this->config->margem / 100)) - $this->wallet->amountmargem;
        }
        
        $this->ordersHistory = Order::where('type', 'future')->where('person_id', $this->person->id)->orderBy('created_at', 'desc')->paginate(25)->items();

        $latestPricing = Pricing::orderBy('id', 'desc')->first();

        if ($latestPricing) {
            // $this->price = $latestPricing->price_open;
            $this->price = $latestPricing->price_open;
        } else {
            // Handle the case where no pricing record exists
            $this->price_open = 0; // or some default value, or trigger an exception, etc.
        }

        $this->total = 0;
        $this->totalOperation = 0.00;
        $this->priceBuy = 0.00;
        $this->priceSell = 0.00;
        $this->rangeValue = 1;
    }
    
    public function render()
    {
        $this->dispatchBrowserEvent('contentChanged');
        return view('livewire.show-trade')->layout('layouts.trade');
    }

    public function setTypecoin($typeCoin)
    {
        info("coin updated to: {$typeCoin}");
        $this->typeCoin = $typeCoin;
        $this->priceBuy = 0;
        $this->priceSell = 0;
        $this->totalOperation = 0;
        $this->total = 0.00;
        $this->amount = 0;
        $this->render();
    }

    public function reload()
    {
        $this->total = 0.00;
        $this->priceBuy = 0.00;
        $this->priceSell = 0.00;
        $this->amount = 0;
        $this->config = Config::select(['logomarca', 'margem'])->first();
        $this->ordersBook = Order::where('type', 'future')->where('status','open')->orderBy('created_at', 'desc')->paginate(10)->items();
        $this->ordersOpen = Order::where('type', 'future')->where('person_id', $this->person->id)
        ->where('status','open')         
        ->orderBy('created_at', 'desc')           
        ->get();
        $this->ordersClose = Order::where('type', 'future')->where('person_id', $this->person->id)
        ->where('status','close')  
        ->orderBy('created_at', 'desc')                  
        ->get();
        $this->wallet = Wallet::where('person_id', $this->person->id)->first();
        if ($this->ordersOpen->count() == 0) {
            $this->wallet->update([
                'amountmargem' => 0,
                'isoperated' => false
            ]);
        }

        // if ($this->wallet->amountmargem > 0 && $this->wallet->isoperated == true) {
        if ($this->wallet->isoperated == true) {
            $this->calcMargem = $this->wallet->amountmargem;

        } else {
            $this->calcMargem = ($this->wallet->amountusdt * ($this->config->margem / 100)) - $this->wallet->amountmargem;
        }
        $this->totalOperation = 0.00;
        $this->rangeValue = 1;
    }

    function calculateTotalValue($inputBitcoinPrice, $inputBitcoinPurchased) {

        $bitcoinPrice = floatval(str_replace(',', '.', $inputBitcoinPrice));

        $bitcoinAmount = floatval(str_replace(',', '.', $inputBitcoinPurchased));

        return floatval($bitcoinPrice) * floatval($bitcoinAmount);
    }

    public function handleOrderScoreBuy()
    {
        if ($this->typeCoin == 'USDT') {
            $this->orderScoreBuyUsdt();
        } else {
            $this->orderScoreBuy();
        }
    }

    public function handleOrderScoreSell()
    {
        if ($this->typeCoin == 'USDT') {
            $this->orderScoreSellUsdt();
        } else {
            $this->orderScoreSell();
        }
    }

    public function orderScoreBuy()
    {
        $margem = Config::first()->margem / 100;
        
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
        
        $this->amount = str_replace(',', '.', $this->amount);
        if($this->amount <= 0)
        {
            $this->addError("orderError", "Quantidade inválida.");

            return ["error" => "Quantidade inválida."];
        }

        // Calcula o valor mínimo necessário no saldo considerando a margem de 125 vezes
        $maxRequiredBalance = $wallet->amountusdt * $margem;
        // Calcula o valor mínimo necessário no saldo considerando a margem de 125 vezes
        if ($this->typeCoin == 'USDT') {
            $maxRequiredAmount = floatval(str_replace(',', '.', $this->amount));
        } else {
            $maxRequiredAmount = floatval(str_replace(',', '.', $this->amount)) * $this->price;
        }

        $this->totalOperation = $maxRequiredAmount * (1 + $this->cost); //OPERAÇÃO MAIS OS CUSTOS
        $cost = $maxRequiredAmount * ($this->cost); // CUSTOS DA OPERAÇÃO

        // Verifica se o usuário tem saldo suficiente considerando a margem
        if ($maxRequiredBalance < $maxRequiredAmount || $wallet->amountusdt <= 0) {
            
            $this->addError("orderError", "Saldo insuficiente para a margem de operação.");

            return ["error" => "Saldo insuficiente para a margem de operação."];
        }

       // dd(floatval($this->amount));

        $total = $this->calculateTotalValue(floatval($this->price), floatval($this->amount));
        if ($total < 2)  {
            $this->addError("orderError", "O valor total do pedido deve ser de no mínimo 2 USDT.");
            return ["error" => "O valor total do pedido deve ser de no mínimo 2 USDT."];
        }
        
        $order = Order::create([

            'person_id'     => $this->person->id ?? null,
            'price_open'    => floatval(str_replace(',', '.', $this->price))?? null,
            'amount'        => floatval(str_replace(',', '.', $this->amount))?? null,
            'total'         => $total,
            'status'        => 'open',
            'take_proft'    => floatval($this->takeProft) ?? null,
            'stop_loss'     => floatval($this->stopLoss) ?? null,
            'direction'     => 'buy',
            'type'          => 'future',
            'typecoin'      => 'BTC'
        ]);

        $updateAmount = $maxRequiredAmount / $margem + $cost;
        
        $valorMargem = $wallet->amountusdt * $margem;
        if ($wallet->amountmargem > 0) {
            $calc = (float) number_format($wallet->amountmargem - $total, 2, '.', '');
        }else {
            $calc = (float) number_format($valorMargem - ($wallet->amountmargem + $total), 2, '.', '');
        }

        $wallet->update([
            // 'amountusdt' => $wallet->amountusdt - $updateAmount
            'amountusdt' => number_format($wallet->amountusdt - $total, 2, '.', ''),
            // 'amountmargem' => number_format($valorMargem - ($wallet->amountmargem + floor($total)), 2, '.', ''),
            'amountmargem' => $calc,
            'isoperated' => true
        ]);

        $this->dispatchBrowserEvent('rangevalue', []);

        $this->reload();

        return ["success" => "Deu certo"];
    }

    public function orderScoreBuyUsdt()
    {
        $margem = Config::first()->margem / 100;
        
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

        $this->amount = str_replace(',', '.', $this->amount);
        if($this->amount <= 0)
        {
            $this->addError("orderError", "Quantidade inválida.");

            return ["error" => "Quantidade inválida."];
        }

        // Calcula o valor mínimo necessário no saldo considerando a margem de 125 vezes
        $maxRequiredBalance = $wallet->amountusdt * $margem;
        // Calcula o valor mínimo necessário no saldo considerando a margem de 125 vezes
        $maxRequiredAmount = floatval(str_replace(',', '.', $this->amount));


        $this->totalOperation = $maxRequiredAmount * (1 + $this->cost); //OPERAÇÃO MAIS OS CUSTOS
        $cost = $maxRequiredAmount * ($this->cost); // CUSTOS DA OPERAÇÃO

        // Verifica se o usuário tem saldo suficiente considerando a margem
        if ($maxRequiredBalance < $maxRequiredAmount || $wallet->amountusdt <= 0) {
            
            $this->addError("orderError", "Saldo insuficiente para a margem de operação.");

            return ["error" => "Saldo insuficiente para a margem de operação."];
        }

       // dd(floatval($this->amount));

        $total = floatval($this->amount);

        if ($total < 2)  {
            $this->addError("orderError", "O valor total do pedido deve ser de no mínimo 2 USDT.");
            return ["error" => "O valor total do pedido deve ser de no mínimo 2 USDT."];
        }
        
        $order = Order::create([

            'person_id'     => $this->person->id ?? null,
            'price_open'    => floatval(str_replace(',', '.', $this->price))?? null,
            'amount'        => floatval(str_replace(',', '.', ($this->amount / $this->price)))?? null,
            'total'         => $total,
            'status'        => 'open',
            'take_proft'    => floatval($this->takeProft) ?? null,
            'stop_loss'     => floatval($this->stopLoss) ?? null,
            'direction'     => 'buy',
            'type'          => 'future',
            'typecoin'      => 'USDT'
        ]);

        $updateAmount = $maxRequiredAmount / $margem + $cost;
        
        $valorMargem = $wallet->amountusdt * $margem;
        if ($wallet->amountmargem > 0) {
            $calc = (float) number_format($wallet->amountmargem - $total, 2, '.', '');
        }else {
            $calc = (float) number_format($valorMargem - ($wallet->amountmargem + $total), 2, '.', '');
        }

        $subtractedValue = $wallet->amountusdt - $total;
        $wallet->update([
            // 'amountusdt' => $wallet->amountusdt - $updateAmount
            'amountusdt' => number_format($subtractedValue, 2, '.', ''),
            // 'amountmargem' => number_format($valorMargem - ($wallet->amountmargem + floor($total)), 2, '.', ''),
            'amountmargem' => $calc,
            'isoperated' => true
        ]);

        $this->dispatchBrowserEvent('rangevalue', []);

        $this->reload();

        return ["success" => "Deu certo"];
    }

    public function orderScoreSell()
    {
        $margem = Config::first()->margem / 100;
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
    
        $this->amount = str_replace(',', '.', $this->amount);
        if($this->amount <= 0)
        {
            $this->addError("orderError", "Quantidade inválida.");

            return ["error" => "Quantidade inválida."];
        }

        // Calcula o valor mínimo necessário no saldo considerando a margem de 125 vezes
        $maxRequiredBalance = $wallet->amountusdt * $margem;
        // Calcula o valor mínimo necessário no saldo considerando a margem de 125 vezes
        // $maxRequiredAmount = floatval(str_replace(',', '.', $this->amount)) * $this->price;
        if ($this->typeCoin == 'USDT') {
            $maxRequiredAmount = floatval(str_replace(',', '.', $this->amount));
        } else {
            $maxRequiredAmount = floatval(str_replace(',', '.', $this->amount)) * $this->price;
        }

        $this->totalOperation = $maxRequiredAmount * (1 + $this->cost); //OPERAÇÃO MAIS OS CUSTOS
        
        $cost = $maxRequiredAmount * ($this->cost); // CUSTOS DA OPERAÇÃO

        // Verifica se o usuário tem saldo suficiente considerando a margem
        if ($maxRequiredBalance < $maxRequiredAmount || $wallet->amountusdt <= 0) {
            
            $this->addError("orderError", "Saldo insuficiente para a margem de operação.");

            return ["error" => "Saldo insuficiente para a margem de operação."];
        }
        
        $total = $this->calculateTotalValue($this->price, $this->amount);
        if ($total < 2)  {
            $this->addError("orderError", "O valor total do pedido deve ser de no mínimo 2 USDT.");
            return ["error" => "O valor total do pedido deve ser de no mínimo 2 USDT."];
        }
        $order = Order::create([

            'person_id'     => $this->person->id ?? null,
            'price_open'         => floatval(str_replace(',', '.', $this->price))?? null,
            'amount'        => floatval(str_replace(',', '.', $this->amount))?? null,
            'total'         => $total,
            'status'        => 'open',
            'take_proft'    => floatval($this->takeProft) ?? null,
            'stop_loss'     => floatval($this->stopLoss) ?? null,
            'direction'     => 'sell',
            'type'          => 'future'
        ]);

        $updateAmount = $maxRequiredAmount / $margem + $cost;

        // $wallet->update([
        //     // 'amountusdt' => $wallet->amountusdt - $updateAmount
        //     // 'amountusdt' => $wallet->amountusdt - $this->totalOperation
        //     'amountusdt' => number_format($wallet->amountusdt - floor($this->totalOperation), 2, '.', ''),
        //     'amountmargem' => number_format($wallet->amountmargem - floor($total), 2, '.', '')
        // ]);
        $valorMargem = $wallet->amountusdt * $margem;
        if ($wallet->amountmargem > 0) {
            $calc = (float) number_format($wallet->amountmargem - $total, 2, '.', '');
        }else {

            $calc = (float) number_format($valorMargem - ($wallet->amountmargem + $total), 2, '.', '');
        }
        $wallet->update([
            // 'amountusdt' => $wallet->amountusdt - $updateAmount
            // 'amountusdt' => number_format($wallet->amountusdt - floor($this->totalOperation), 2, '.', ''),
            'amountusdt' => number_format($wallet->amountusdt - $total, 2, '.', ''),
            // 'amountmargem' => number_format($wallet->amountmargem + floor($total), 2, '.', ''),
            // 'amountmargem' => number_format($valorMargem - ($wallet->amountmargem + floor($total)), 2, '.', ''),
            'amountmargem' => $calc,
            'isoperated' => true

        ]);

        $this->dispatchBrowserEvent('rangevalue', []);

        $this->reload();


        return ["success" => "Deu certo"];
    }

    public function orderScoreSellUsdt()
    {
        $margem = Config::first()->margem / 100;
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
    
        $this->amount = str_replace(',', '.', $this->amount);
        if($this->amount <= 0)
        {
            $this->addError("orderError", "Quantidade inválida.");

            return ["error" => "Quantidade inválida."];
        }

        // Calcula o valor mínimo necessário no saldo considerando a margem de 125 vezes
        $maxRequiredBalance = $wallet->amountusdt * $margem;
        // Calcula o valor mínimo necessário no saldo considerando a margem de 125 vezes
        // $maxRequiredAmount = floatval(str_replace(',', '.', $this->amount)) * $this->price;
        if ($this->typeCoin == 'USDT') {
            $maxRequiredAmount = floatval(str_replace(',', '.', $this->amount));
        } else {
            $maxRequiredAmount = floatval(str_replace(',', '.', $this->amount)) * $this->price;
        }

        $this->totalOperation = $maxRequiredAmount * (1 + $this->cost); //OPERAÇÃO MAIS OS CUSTOS
        
        $cost = $maxRequiredAmount * ($this->cost); // CUSTOS DA OPERAÇÃO

        // Verifica se o usuário tem saldo suficiente considerando a margem
        if ($maxRequiredBalance < $maxRequiredAmount || $wallet->amountusdt <= 0) {
            
            $this->addError("orderError", "Saldo insuficiente para a margem de operação.");

            return ["error" => "Saldo insuficiente para a margem de operação."];
        }
        
        // $total = $this->calculateTotalValue($this->price, $this->amount);
        $total = floatval($this->amount);
        if ($total < 2)  {
            $this->addError("orderError", "O valor total do pedido deve ser de no mínimo 2 USDT.");
            return ["error" => "O valor total do pedido deve ser de no mínimo 2 USDT."];
        }
        $order = Order::create([

            'person_id'     => $this->person->id ?? null,
            'price_open'         => floatval(str_replace(',', '.', $this->price))?? null,
            // 'amount'        => floatval(str_replace(',', '.', $this->amount))?? null,
            'amount'        => floatval(str_replace(',', '.', ($this->amount / $this->price)))?? null,
            'total'         => $total,
            'status'        => 'open',
            'take_proft'    => floatval($this->takeProft) ?? null,
            'stop_loss'     => floatval($this->stopLoss) ?? null,
            'direction'     => 'sell',
            'type'          => 'future'
        ]);

        $updateAmount = $maxRequiredAmount / $margem + $cost;

        // $wallet->update([
        //     // 'amountusdt' => $wallet->amountusdt - $updateAmount
        //     // 'amountusdt' => $wallet->amountusdt - $this->totalOperation
        //     'amountusdt' => number_format($wallet->amountusdt - floor($this->totalOperation), 2, '.', ''),
        //     'amountmargem' => number_format($wallet->amountmargem - floor($total), 2, '.', '')
        // ]);
        $valorMargem = $wallet->amountusdt * $margem;
        if ($wallet->amountmargem > 0) {
            $calc = (float) number_format($wallet->amountmargem - $total, 2, '.', '');
        }else {

            $calc = (float) number_format($valorMargem - ($wallet->amountmargem + $total), 2, '.', '');
        }
        $wallet->update([
            // 'amountusdt' => $wallet->amountusdt - $updateAmount
            // 'amountusdt' => number_format($wallet->amountusdt - floor($this->totalOperation), 2, '.', ''),
            'amountusdt' => number_format($wallet->amountusdt - $total, 2, '.', ''),
            // 'amountmargem' => number_format($wallet->amountmargem + floor($total), 2, '.', ''),
            // 'amountmargem' => number_format($valorMargem - ($wallet->amountmargem + floor($total)), 2, '.', ''),
            'amountmargem' => $calc,
            'isoperated' => true

        ]);

        $this->dispatchBrowserEvent('rangevalue', []);

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
        if ($this->typeCoin == 'USDT') {
            $this->amount = $value;
        } else {
            $this->amount = $newAmount;
        }
        // $this->amount = $newAmount;
        $this->render();

        $this->priceBuy = $buy;
        $this->priceSell = $sell;
        $this->totalOperation = $buy + $buy * $this->cost;
    }

    public function updatedAmount($value)
    {
      
        $amount = is_numeric($value) ? floatval($value) : 0;
   
        // $this->priceBuy = $amount * $this->price;
        // $this->priceSell = $amount * $this->price;

        // $this->totalOperation = $this->priceBuy +  $this->priceBuy * $this->cost;
        if ($this->typeCoin == 'USDT') {
            $this->priceBuy = $amount;
            $this->priceSell = $amount;
            $this->totalOperation = $amount;
        } else {
            $this->priceBuy = $amount * $this->price;
            $this->priceSell = $amount * $this->price;
            $this->totalOperation = $this->priceBuy +  $this->priceBuy * $this->cost;
        }
    }

    public function orderClose($orderId)
    {
        $order = Order::find($orderId);
        $margem = Config::first()->margem / 100;
    
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
//            $gainLossRounded = floor($gainLoss * 100) / 100;
            $gainLoss = number_format($gainLoss, 2, '.');
            $gainLossValue = number_format($gainLoss*$this->margem, 2, '.', '');
        }else{
            $gainLoss = (floatval($order->price_open) - floatval($askPrice)) * $order->amount;
            $gainLoss = number_format($gainLoss, 2, '.');
            $gainLossValue = number_format($gainLoss*$this->margem, 2, '.', '');
        }

        // Atualizar a ordem
        $order->update([
            'status'        => 'closed',
            //'gain_loss'     => $gainLoss,
            'gain_loss'     => $gainLossValue,
            'price_closed'   => floatval($askPrice)
        ]);

        /* AFILIADOS */
        $user = $this->user;
        $calcAfLevel1 = 0.15;
        $calcAfLevel2 = 0.05;
        if ($user->aflevel1) {
            $userAf1 = User::where('code', $user->aflevel1)->first();
            if ($userAf1) {
                $currentAmountAf1 = $userAf1->person->wallet->amountcpa;
                $currentTotalAf1 = $userAf1->person->wallet->cpatotal;
                $userAf1->person->wallet->update([
                    'cpatotal' => $currentTotalAf1 + ($gainLossValue * $calcAfLevel1),
                    'amountcpa' => $currentAmountAf1 + ($gainLossValue * $calcAfLevel1)
                ]);
                $user->update([
                    'sumcpalvl1' => $user->sumcpalvl1 + ($gainLossValue * $calcAfLevel1)
                ]);
            }

            if ($user->aflevel2) {
                $userAf2 = User::where('code', $user->aflevel2)->first();
                if ($userAf2) {
                    $currentAmountAf2 = $userAf2->person->wallet->amountcpa;
                    $currentTotalAf2 = $userAf2->person->wallet->cpatotal;
                    $userAf2->person->wallet->update([
                        'cpatotal' => $currentTotalAf2 + ($gainLossValue * $calcAfLevel1),
                        'amountcpa' => $currentAmountAf2 + ($gainLossValue * $calcAfLevel2)
                    ]);

                    $user->update([
                        'sumcpalvl2' => $user->sumcpalvl2 + ($gainLossValue * $calcAfLevel2)
                    ]);
                }
            }


        }
        /* END AFILIADOS */

        $wallet = Wallet::where('person_id', '=', $order->person_id)->first();

        //dd($wallet->amountusdt + floatval($gainLoss), $wallet->amountmargem, floatval($order->total));
        $formattedTotal = number_format($order->total, 2, '.', '');
        $valorMargem = $wallet->amountusdt * $margem;



        if ($order->direction == 'sell') {
            // $tenPercentGainLoss = $gainLoss * 0.10;
            // if (floatval($gainLoss) < 0) {
            //     $wallet->update([
            //         'amountusdt' => ($wallet->amountusdt + $formattedTotal) - floatval($gainLoss),
            //         'amountmargem' => $wallet->amountmargem - floatval($formattedTotal) - $tenPercentGainLoss,
            //     ]);
            // } else {
            //     $wallet->update([
            //         'amountusdt' => ($wallet->amountusdt + $formattedTotal) - floatval($gainLoss),
            //         'amountmargem' => $wallet->amountmargem - floatval($formattedTotal) - $tenPercentGainLoss,
            //     ]);
            // }
            if (floatval($gainLoss) < 0) {
                // dd(($wallet->amountusdt ."+". $formattedTotal) ."+". floatval($gainLoss));
                $margemGain = floatval($gainLoss) * 0.10;
                $wallet->update([
                    'amountusdt' => ($wallet->amountusdt + $formattedTotal) + floatval($gainLossValue),
                    // 'amountmargem' => $wallet->amountmargem - floatval($order->total),
                    'amountmargem' => ($wallet->amountmargem + floatval($formattedTotal)) + $margemGain,
                ]);
            } else {
                $margemGain = floatval($gainLoss) * 0.10;
                $wallet->update([
                    'amountusdt' => ($wallet->amountusdt + $formattedTotal) + floatval($gainLossValue),
                    // 'amountmargem' => $wallet->amountmargem - floatval($order->total),
                    'amountmargem' => ($wallet->amountmargem + floatval($formattedTotal)) - $margemGain,
                ]);
            }
        } else {
            if (floatval($gainLoss) < 0) {
                // dd(($wallet->amountusdt + $formattedTotal) + floatval($gainLossValue));

                //dd($wallet->amountmargem + floatval($formattedTotal))
                $margemGain = floatval($gainLoss) * 0.10;
                $wallet->update([
                    'amountusdt' => ($wallet->amountusdt + $formattedTotal) + floatval($gainLossValue),
                    // 'amountmargem' => $wallet->amountmargem - floatval($order->total),
                    'amountmargem' => ($wallet->amountmargem + floatval($formattedTotal)) + $margemGain,
                ]);
            } else {
                //dd($wallet->amountmargem + floatval($formattedTotal));
                $margemGain = floatval($gainLoss) * 0.10;
                $wallet->update([
                    'amountusdt' => ($wallet->amountusdt + $formattedTotal) + floatval($gainLossValue),
                    // 'amountmargem' => $wallet->amountmargem - floatval($order->total),
                    'amountmargem' => ($wallet->amountmargem + floatval($formattedTotal)) + $margemGain,
                ]);
            }
        }
        
    
        $this->reload();
    }
    


    


    
}