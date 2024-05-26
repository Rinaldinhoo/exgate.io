<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Config;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Password;
use App\Mail\PasswordReset;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class ShowForgot extends Component
{

    public $senha;
    public $senhaconfirm;
    public $token;
    public $config;

    public function mount()
    {
        $this->config = Config::select('logomarca')->first();
        if(request()->has('token')) {
            // Define o valor do token usando o parâmetro 'token' da URL
            $this->token = request('token');
    
            // Verifica se o token é válido
            $user = User::where('tokenreset', $this->token)->first();
            if (!$user) {
                abort(404); // Retorna uma página 404 se não houver token na URL

            }
        } else {
            abort(404); // Retorna uma página 404 se não houver token na URL
        }
    }

    public function render()
    {
        return view('livewire.show-forgot')->layout('layouts.forgot');
    }

    public function updatePassword()
    {
        $this->validate([
            'senha' => 'required|min:8',
            'senhaconfirm' => 'required',
        ]);

        if ($this->senha !== $this->senhaconfirm) {
            // Adiciona um erro personalizado ao campo 'senhaconfirm'
            $this->addError('senhaconfirm', 'A confirmação da senha não coincide.');
            return;
        }
    
        $user = User::where('tokenreset', $this->token)->first();
        if ($user) {
            $user->update([
                'password' => Hash::make($this->senha),
                'tokenreset' => null
            ]);

            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'title' => 'Sucesso!',
                'text' => 'A senha foi alterada com sucesso.',
            ]);
        }
    }
}