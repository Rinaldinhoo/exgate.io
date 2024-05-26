<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Password;
use App\Mail\PasswordReset;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\Config;

class ShowVerified extends Component
{
    public $config;

    public function mount()
    {
        $this->config = Config::select('logomarca')->first();

        if(request()->has('token')) {
            // Define o valor do token usando o parâmetro 'token' da URL
            $this->token = request('token');
    
            // Verifica se o token é válido
            $user = User::where('tokenverified', $this->token)->first();
            if ($user) {
                $user->update([
                    'email_verified_at' => now(),
                    'tokenverified' => null
                ]);
            }
        } else {
            abort(404); // Retorna uma página 404 se não houver token na URL
        }
    }

    public function render()
    {
        return view('livewire.show-verified')->layout('layouts.verified');
    }
}