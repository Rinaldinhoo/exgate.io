<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;

use App\Models\Person;

use Illuminate\Support\Str;

use RobThree\Auth\TwoFactorAuth;

use Illuminate\Http\Request;
use App\Models\Config;

class ShowSecurity extends Component
{
    public $user;
    public $person;
    public $qrCodeUrl;
    public $secret;
    public $codeCheck;
    public $config;

    protected $listeners = [
        'updatecode' => 'setCode',
    ];

    public function mount()
    {
        $this->user = Auth::user();
        $this->config = Config::select('logomarca')->first();

        // $this->user->name = Str::limit($this->user->name, 15);

        // $this->user->email = Str::limit($this->user->email, 15);
        
        $this->person = Person::where('user_id', $this->user->id)->first();

        if ($this->secret == false) {
            $tfa = new TwoFactorAuth();
            $secret = $this->user->code2fa;
            if (empty($this->user->code2fa)) {
                $secret = $tfa->createSecret();
                $this->user->update([
                    'code2fa' => $secret
                ]);
            }
            $this->qrCodeUrl = $tfa->getQRCodeImageAsDataUri('Exgate.IO', $secret);
        }
        $this->user->name = Str::limit($this->user->name, 15);

        $this->user->email = Str::limit($this->user->email, 15);
    }

    public function excludeAccount()
    {
        // Verifica se o usuário atual está autenticado
        if (Auth::check()) {
            // Obtém o usuário autenticado
            $user = Auth::user();
            
            // Define o campo 'deleted_at' como a data e hora atual para desativar o usuário
            $user->deleted_at = now();
            
            // Salva as alterações no banco de dados
            $user->save();
            Auth::logout();
        }
    }

    public function render()
    {
        return view('livewire.show-security')->layout('layouts.security');
    }

    public function setCode($value)
    {
        $this->codeCheck = $value;
        $this->render();      

    }

    public function excludeCheckfa()
    {
        $user = Auth::user();
        $user->update([
            'is2fa' => false,
        ]);
    }

    public function checkfa(Request $request)
    {
        $user = Auth::user();
        $codeCheck = $request->codeCheck;
        $tfa = new TwoFactorAuth();
        $result = $tfa->verifyCode($user->code2fa, $codeCheck);
        if ($result) {
            $user->update([
                'is2fa' => true
            ]);
            return response()->json('Foi habilitado com sucesso 2FA', 200);
        } else {
            return response()->json('Por favor, verifique o código!', 500);
        }

    }
}
