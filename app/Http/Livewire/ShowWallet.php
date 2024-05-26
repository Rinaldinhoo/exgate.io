<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Person;
use App\Models\Order;
use App\Models\Config;
use App\Models\TransactionHistory;
use App\Models\InternalTransfer;
use App\Http\Api\BinanceController;
use Illuminate\Support\Facades\Http;
use RobThree\Auth\TwoFactorAuth;

class ShowWallet extends Component
{

    public $successMessage;

    public $user;
    public $person;
    public $wallet;
    public $ordersBuy;
    public $ordersSell;
    public $value;
    public $address;
    public $taxa;
    public $historys;
    public $priceBrl;
    public $pctChangeUsd;
    public $pctChange;
    public $cpf;
    public $namecomplete;
    public $codeCheck2fa;
    public $config;
    public $bank;
    public $agency;
    public $currency;
    public $depositValue;

    public $numberAccount;
    public $amontTranfer;
    public $price;
    public $typeCoin = 'USDT';
    
    protected $listeners = [
        'updatecoin' => 'setTypecoin',
    ];

    public function mount()
    {
        $this->config = Config::select('logomarca')->first();
        $this->user = Auth::user();
        $this->user->name = Str::limit($this->user->name, 15);
        $this->user->email = Str::limit($this->user->email, 15);
        $this->person = Person::where('user_id', $this->user->id)->first();
        $this->wallet = Wallet::where('person_id', $this->person->id)->first();
        $this->config = Config::first();

        $this->value = 0.00;
        $this->address = '';
        $this->taxa = $this->config->taxa;
        $this->numberAccount = '';
        $this->amontTransfer = 0.00;
        $this->successMessage = '';

        $this->historys = TransactionHistory::where('wallet_id', '=', $this->wallet->id)->orderBy('id', 'desc')->limit(25)->get();
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
        $binanceController = new BinanceController();

        $priceResponse = $binanceController->lastPricing();
        if ($priceResponse instanceof \Illuminate\Http\JsonResponse) {
            // Decodifica o JSON para um array PHP
            $data = $priceResponse->getData(true);
            $this->price = $data['askPrice'];
        } else {
            // Se a resposta for um array ou outro tipo
            $this->price = $priceResponse['askPrice'];
        }

        $this->ordersBuy = Order::where('person_id', $this->person->id)
        ->where('status', 'open')
        ->where('direction', 'buy')
        ->sum(\DB::raw('amount * price_open')) / 125;

        $this->ordersSell= Order::where('person_id', $this->person->id)
        ->where('status', 'open')
        ->where('direction', 'sell')
        ->sum(\DB::raw('amount * price_open')) / 125;

    }

    public function render()
    {
        return view('livewire.show-wallet')->layout('layouts.wallet');
    }

    public function setTypecoin($typeCoin)
    {
        info("Price updated to: {$typeCoin}");
        $this->typeCoin = $typeCoin;
        $this->render();
    }

    public function depositInternal()
    {
        if (!is_numeric($this->depositValue) || $this->depositValue <= 0 || $this->depositValue === '') {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'title' => 'Erro!',
                'text' => 'Valor inválido.',
            ]);
        
            return ["error" => "Valor inválido."];
        }

        if ($this->depositValue < 10) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'title' => 'Erro de Validação!',
                'text' => 'O valor mínimo informado não é válido. Por favor, verifique e tente novamente.',
            ]);
        
            return ["error" => "Valor inválido."];
        }

        $deposit = TransactionHistory::create([
            'wallet_id' => $this->wallet->id,
            'amount' => $this->depositValue,
            'address' => $this->address,
            'type' => 'Deposito',
            'coin' => 'USDT',
            'status' => 'Pendente',
            'user_id' => $this->user->id
        ]);

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'title' => 'Operação Realizada com Sucesso',
            'text' => 'Realize o depósito do valor selecionado e aguarde conclusão.',
        ]);
    }

    public function withdrawal()
    {
        $this->value = str_replace( ',','.',$this->value);

        if (!$this->codeCheck2fa)  {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'title' => 'Erro!',
                'text' => 'Necessário Colocar 2FA',
            ]);
            return ["error" => "Dois Fatores Inválido."];
        }

        $tfa = new TwoFactorAuth();
        $result = $tfa->verifyCode($this->user->code2fa, $this->codeCheck2fa);
        if (!$result)  {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'title' => 'Erro!',
                'text' => 'Autenticação de dois fatores inválida.',
            ]);
            return ["error" => "Dois Fatores Inválido."];
        }

        if (!is_numeric($this->value) || $this->value <= 0 || $this->value === '') {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'title' => 'Erro!',
                'text' => 'Valor inválido.',
            ]);
        
            return ["error" => "Valor inválido."];
        }

        $amount = $this->wallet->amount;
        $typeAmount = 'amount';

        if ($this->typeCoin == 'BRL') {
            $amount = $this->wallet->amountbrl;
            $typeAmount = 'amountbrl';
        } else if ($this->typeCoin == 'USDT') {
            $amount = $this->wallet->amountusdt;
            $typeAmount = 'amountusdt';
        }

        if($amount < $this->value)
        {
            $this->addError("withdrawalError", "Saldo insuficiente. " . $this->typeCoin);

            return ["error" => "Valor inválido."];
        }

        if($this->address == '' && $this->typeCoin == 'USDT')
        {
            $this->addError("withdrawalError", "Endereço da carteira inválido.");

            return ["error" => "Valor inválido."];
        }

        $this->wallet->update([
            $typeAmount => $amount - $this->value
        ]);

        $withdrawal = TransactionHistory::create([

            'wallet_id' => $this->wallet->id,
            'amount' => $this->value,
            'address' => $this->address,
            'type' => 'Saque',
            'coin' => $this->typeCoin,
            'status' => 'Pendente',
            'user_id' => $this->user->id,
            'cpf' => $this->cpf,
            'namecomplete' => $this->namecomplete,
            'bank' => $this->bank,
            'agency' => $this->agency,
            'currency' => $this->currency,
        ]);

        $this->historys = TransactionHistory::where('wallet_id', '=', $this->wallet->id)->orderBy('id','desc')->limit(25)->get();
        
        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'title' => 'Operação Realizada com Sucesso',
            'text' => 'Sua retirada foi realizada com sucesso e está em processamento. Por favor, aguarde a conclusão.',
        ]);

        $this->value = 0.00;
        $this->address = '';
        
    }

    public function transferInternal()
    {       

        if($this->numberAccount === null || $this->numberAccount === '')
        {
            $this->addError("transferError", "Você não informou o código da conta.");

            return ["error" => "Valor inválido."];
        }

        // if($this->amontTranfer === null || $this->amontTranfer === '' || $this->amontTranfer > 5)
        // {
        //     $this->addError("transferError", "Valor mínimo é 0.1 BTC.");

        //     return ["error" => "Valor inválido."];
        // }

        $this->amontTranfer = str_replace( ',','.', $this->amontTranfer);

        if($this->wallet->amount < $this->amontTranfer)
        {
            $this->addError("transferError", "Saldo insuficiente para transferência.");

            return ["error" => "Valor inválido."];
        }

        $userTransfer = User::where('code', $this->numberAccount)->first();

        if(!$userTransfer) {
            $this->addError("transferError", "Código do usuário inválido.");
            return ["error" => "Código inválido."];
        }

        $this->wallet->decrement('amount', $this->amontTranfer);

        $walletTransfer = $userTransfer->person->wallet;
        $personTransfer = $userTransfer->person;

        $walletTransfer->increment('amount', $this->amontTranfer);

        $internalTransfer = InternalTransfer::create([
            'whallet_sender_id' => $this->wallet->id,
            'whallet_destination_id' => $walletTransfer->id,
            'amount' => $this->amontTranfer,
            'status' => 'Concluído'
        ]);

        $this->numberAccount = '';
        $this->amontTransfer = 0.00;

        $withdrawal = TransactionHistory::create([

            'wallet_id' => $this->wallet->id,
            'amount' => $this->amontTranfer,
            'address' => $this->numberAccount,
            'type' => 'Tranferência/Saída',
            'coin' => 'BTC',
            'status' => 'Concluído',
            'user_id' => $this->user->id
        ]);

        $withdrawal = TransactionHistory::create([

            'wallet_id' => $walletTransfer->id,
            'amount' => $this->amontTranfer,
            'address' => $this->numberAccount,
            'type' => 'Tranferência/Entrada',
            'coin' => 'BTC',
            'status' => 'Concluído',
            'user_id' => $personTransfer->user_id
        ]);

        $this->historys = TransactionHistory::where('wallet_id', '=', $this->wallet->id)->orderBy('id','desc')->limit(25)->get();

        $this->successMessage = 'Tranferência realizada com sucesso!';
    }
}
