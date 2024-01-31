<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ShowLogin extends Component
{

    public $email;
    public $password;

    public function render()
    {
        return view('livewire.show-login')->layout('layouts.auth');
    }

    public function login()
    {
        $mensagens = [
            'email.required' => 'O email é obrigatório.',
            'password.required' => 'A senha é obrigatória.',
        ];

        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], $mensagens);


        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {


            Auth::user()->update(['last_login' => Carbon::now('America/Sao_Paulo')]);


            return redirect()->route('welcome');


        }
    
        $this->addError('loginError', 'E-mail ou senha inválidos.');

    }
}
