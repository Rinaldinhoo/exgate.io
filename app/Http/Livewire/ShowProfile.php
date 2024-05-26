<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;

use App\Models\Person;

use Illuminate\Support\Str;
use App\Models\Config;

class ShowProfile extends Component
{
    public $user;
    public $person;
    public $namecomplete;
    public $imageprofile;
    public $datebirth;
    public $email;
    public $config;
    public $address;

    public function mount()
    {
        $this->user = Auth::user();
        $this->config = Config::select('logomarca')->first();

        $this->user->name = Str::limit($this->user->name, 15);

        $this->user->email = Str::limit($this->user->email, 15);
        
        $this->person = Person::where('user_id', $this->user->id)->first();

        $this->namecomplete = $this->person->name;
        $this->datebirth = $this->person->birthday;
        $this->email = $this->person->email;
        $this->address = $this->person->address;
    }

    public function render()
    {
        return view('livewire.show-profile')->layout('layouts.profile');
    }

    public function updateProfile()
    {
        $this->validate([
            'namecomplete' => 'required',
            //'imageprofile' => 'required',
            'datebirth' => 'required|date_format:Y-m-d', // Validando como string para conversão manual
            'address' => 'required',
        ]);

        $this->person->birthday = $this->datebirth;
        
        $this->person->name = $this->namecomplete;
        $this->person->address = $this->address;
        
        $this->person->save();
        
        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'title' => 'Sucesso!',
            'text' => 'Perfil atualizado com sucesso!',
        ]);
    }
}
