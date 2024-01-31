<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;

use App\Models\Person;

use Illuminate\Support\Str;

class ShowIdentification extends Component
{
    public $user;
    
    public $person;

    public function mount()
    {
        $this->user = Auth::user();

        $this->user->name = Str::limit($this->user->name, 15);

        $this->user->email = Str::limit($this->user->email, 15);

        $this->person = Person::where('user_id', $this->user->id)->first();
    }

    public function render()
    {
        return view('livewire.show-identification')->layout('layouts.identification');
    }
}
