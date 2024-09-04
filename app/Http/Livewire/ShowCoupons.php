<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;

use App\Models\Person;

use App\Models\Config;
use App\Models\Wallet;
use App\Models\User;

use Illuminate\Support\Str;

class ShowCoupons extends Component
{

    public $user;
    
    public $person;
    public $config;
    public $wallet;
    public $affList;

    public function mount()
    {
        $this->user = Auth::user();
        $this->config = Config::select('logomarca')->first();

        $this->user->name = Str::limit($this->user->name, 15);

        $this->user->email = Str::limit($this->user->email, 15);

        $this->person = Person::where('user_id', $this->user->id)->first();
        
        $this->wallet = Wallet::where('person_id', $this->person->id)->first();
        
        //$this->affList = User::where('aflevel1', $this->user->code)->Orwhere('aflevel2', $this->user->code)->orderBy('id', 'desc')->get();
        $this->affList = User::where(function ($query) {
            $query->where('aflevel1', $this->user->code)
                  ->orWhere('aflevel2', $this->user->code);
        })
        ->where(function ($query) {
            $query->where('aflevel1', '>', 0)
                  ->orWhere('aflevel2', '>', 0);
        })
        ->orderBy('id', 'desc')
        ->get();
    }

    public function render()
    {
        return view('livewire.show-coupons')->layout('layouts.coupons');
    }

    public function rescueComission()
    {
        $wallet = $this->wallet;

        if ($wallet->amountcpa <= 0) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'title' => 'Erro!',
                'text' => 'Não possui comissao.',
            ]);
        }

        $wallet->update([
            'amountusdt' => $wallet->amountusdt + $wallet->amountcpa,
            'amountcpa'  => 0
        ]);

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'title' => 'Operação Realizada com Sucesso',
            'text' => 'Alguns segundos estará na sua conta.',
        ]);
    }
}
