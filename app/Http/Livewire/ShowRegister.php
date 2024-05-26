<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Mail\VerifiedEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Livewire\Component;
use App\Models\User;
use App\Models\Person;
use App\Models\Wallet;
use Illuminate\Support\Facades\Mail;
use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ShowRegister extends Component
{
    public $email;
    public $name;
    public $password;
    public $phone;
    public $config;
    public $af;

    public function mount(Request $request)
    {
        $this->config = Config::select('logomarca')->first();

        if ($request->has('aff')) {
            $aff = $request->input('aff');
            Session::put('aff', $aff);
        } else {
            $aff = Session::get('aff');
        }

        $this->af = $aff;
    }

    public function render()
    {
        return view('livewire.show-register')->layout('layouts.auth');
    }

    public function register()
    {
        Validator::extend('unique_ignoring_soft_deletes', function ($attribute, $value, $parameters, $validator) {
            // Assume que $parameters[0] é o nome da tabela e $parameters[1] é o nome da coluna
            $count = \DB::table($parameters[0])
                        ->where($parameters[1], $value)
                        ->whereNull('deleted_at') // Ignora os registros soft deleted
                        ->count();
        
            return $count === 0; // Retorna true se não houver registros, indicando que a validação passou
        });

        $mensagens = [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'email.unique_ignoring_soft_deletes' => 'Este email já está em uso.',
            'phone.required' => 'O telefone é obrigatório.',
            'password.required' => 'A senha é obrigatória.',
            'phone.unique' => 'Este telefone já está em uso.',
        ];

        $this->validate([
            'name' => 'required|string',
            'email' => ['required', 'email', 'unique_ignoring_soft_deletes:users,email'],
            'phone' => 'required',
            'password' => 'required|min:6',
        ], $mensagens);


        $affiliateId = Session::get('aff');
        $level1AffiliateId = null;
        $level2AffiliateId = null;

        if ($affiliateId) {
            $level1AffiliateId = $affiliateId;

            $level1Affiliate = User::where('code', $level1AffiliateId)->first();
            $level2AffiliateId = $level1Affiliate->aflevel1 ?? null;
        }
        $user = User::create([
            'name'      => $this->name,
            'email'     => $this->email,
            'password'  => bcrypt($this->password),
            'last_login'=> Carbon::now('America/Sao_Paulo'),
            'aflevel1'  => $level1Affiliate->code??null,
            'aflevel2'  => $level2AffiliateId
        ]);

        $user->update([
            'code'=> mt_rand(1000000000, 9999999999).''.$user->id
        ]);

        $person = Person::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'user_id' => $user->id
        ]);

        $wallet = Wallet::create([
            'person_id' => $person->id,
            'amount'    => 0
        ]);

        try { 
            $token = $this->generateRandomToken();
            $verificationLink = "https://app.exgate.io/verified?token=".$token;
            $user->update([
                'tokenverified' => $token
            ]);
            Mail::to($this->email)->send(new VerifiedEmail($verificationLink));
        } catch (Exception $e) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'title' => 'Erro!',
                'text' => 'Não foi possível enviar o e-mail. Por favor, entre em contato com o suporte.',
            ]);
        }
        Auth::login($user);
        
        return redirect('https://app.exgate.io/welcome');
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
