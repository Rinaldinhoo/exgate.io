<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;



use Livewire\Component;
use App\Models\User;
use App\Models\Person;
use App\Models\Wallet;


class ShowRegister extends Component
{
    public $email;
    public $name;
    public $password;

    public function render()
    {
        return view('livewire.show-register')->layout('layouts.auth');
    }

    public function register()
    {

        $mensagens = [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'password.required' => 'A senha é obrigatória.',
        ];

        $this->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], $mensagens);



        $user = User::create([
            'name'      => $this->name,
            'email'     => $this->email,
            'password'  => bcrypt($this->password),
            'last_login'=> Carbon::now('America/Sao_Paulo')
        ]);


        $user->update([
            'code'=> mt_rand(1000000000, 9999999999).''.$user->id
        ]);

        $person = Person::create([
            'name' => $this->name,
            'email' => $this->email,
            'user_id' => $user->id
        ]);

        $wallet = Wallet::create([
            'person_id' => $person->id,
            'amount'    => 0
        ]);

        Auth::login($user);
        
        return redirect()->route('welcome');
    }
}
