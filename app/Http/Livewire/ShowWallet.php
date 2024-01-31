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

    public $numberAccount;
    public $amontTranfer;

    public function mount()
    {
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

        $this->historys = TransactionHistory::where('wallet_id', '=', $this->wallet->id)->orderBy('id', 'desc')->limit(25)->get();

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


    public function withdrawal()
    {
        $this->value = str_replace( ',','.',$this->value);

        if($this->value <= 0 || $this->value == '')
        {
            $this->addError("withdrawalError", "Valor inválido.");

            return ["error" => "Valor inválido."];
        }

        if($this->wallet->amount < $this->value)
        {
            $this->addError("withdrawalError", "Saldo insuficiente.");

            return ["error" => "Valor inválido."];
        }

        if($this->address == '')
        {
            $this->addError("withdrawalError", "Endereço da carteira inválido.");

            return ["error" => "Valor inválido."];
        }

        $this->wallet->update([
            'amount' => $this->wallet->amount - $this->value
        ]);

        $withdrawal = TransactionHistory::create([

            'wallet_id' => $this->wallet->id,
            'amount' => $this->value,
            'address' => $this->address,
            'type' => 'Saque',
            'coin' => 'USDT',
            'status' => 'Pendente'
        ]);

        $this->historys = TransactionHistory::where('wallet_id', '=', $this->wallet->id)->orderBy('id','desc')->limit(25)->get();

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

        if($this->amontTranfer === null || $this->amontTranfer === '' || $this->amontTranfer < 10)
        {
            $this->addError("transferError", "Valor mínimo é 10 USDT.");

            return ["error" => "Valor inválido."];
        }

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
            'coin' => 'USDT',
            'status' => 'Concluído'
        ]);

        $withdrawal = TransactionHistory::create([

            'wallet_id' => $walletTransfer->id,
            'amount' => $this->amontTranfer,
            'address' => $this->numberAccount,
            'type' => 'Tranferência/Entrada',
            'coin' => 'USDT',
            'status' => 'Concluído'
        ]);

        $this->historys = TransactionHistory::where('wallet_id', '=', $this->wallet->id)->orderBy('id','desc')->limit(25)->get();

        $this->successMessage = 'Tranferência realizada com sucesso!';
    }
}
