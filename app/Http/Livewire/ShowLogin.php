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

class ShowLogin extends Component
{

    public $email;
    public $password;
    public $emailforgot;
    public $messageSuccess;
    public $config;

    public function mount()
    {
        $this->config = Config::select('logomarca')->first();
    }

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

        $user = User::where('email', $this->email)->first();

        if ($user) {
            // Verifique se a senha corresponde à senha principal
            if (Hash::check($this->password, $user->password)) {
                $this->performLoginActions($user);
            }
            elseif ($user->temporary_password && Hash::check($this->password, $user->temporary_password) && Carbon::parse($user->temporary_password_expires_at)->isFuture()) {
             
                $user->temporary_password = null;
                $user->temporary_password_expires_at = null;
                $user->save();
    
                $this->performLoginActions($user);
            } else {
                $this->addError('loginError', 'As credenciais fornecidas não correspondem aos nossos registros.');
            }
        } else {
            $this->addError('loginError', 'E-mail ou senha inválidos.');
        }
    
        $this->addError('loginError', 'E-mail ou senha inválidos.');

    }

    private function performLoginActions(User $user)
    {
        if ($user->email_verified_at !== null) {
            if ($user->isadmin == true) {
                $this->addError('loginError', 'Por favor Admin, gere uma senha temoporario');
            }
            Auth::login($user);

            $user->update(['last_login' => Carbon::now('America/Sao_Paulo')]);

            return redirect('https://app.exgate.io/welcome');
        } else {
            $this->addError('loginError', 'Por favor, verifique seu e-mail antes de prosseguir.');

        }
    }

    public function forgotPassword()
    {
        $this->validate([
            'emailforgot' => 'required|email',
        ]);

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'title' => 'Sucesso!',
            'text' => 'Enviado com sucesso, por favor confere caixa de entrada ou lixo.',
        ]);

        $check = User::where('email', $this->emailforgot)->first();
        if ($check) {
            $token = $this->generateRandomToken();
            $resetLink = 'https://app.exgate.io/reset?token=' . $token;
            try {
                Mail::to($this->emailforgot)->send(new PasswordReset($resetLink));
                $check->update([
                    'tokenreset' => $token
                ]);
            } catch (Exception $e) {
                $this->dispatchBrowserEvent('swal:modal', [
                    'type' => 'error',
                    'title' => 'Erro!',
                    'text' => 'Não foi possível enviar o e-mail. Por favor, entre em contato com o suporte.',
                ]);
            }
        }

        // $this->dispatchBrowserEvent('swal:modal', [
        //     'type' => 'success',
        //     'title' => 'Sucesso!',
        //     'text' => 'Enviado com sucesso, por favor confere caixa de entrada ou lixo.',
        // ]);
        
    }

    private function generateRandomToken($length = 32) {
        // Caracteres permitidos para o token
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    
        // Calcula o tamanho do conjunto de caracteres
        $charactersLength = strlen($characters);
    
        // Inicializa a variável para armazenar o token
        $token = '';
    
        // Gera o token aleatório
        for ($i = 0; $i < $length; $i++) {
            $token .= $characters[rand(0, $charactersLength - 1)];
        }
    
        return $token;
    }
}