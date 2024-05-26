<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;

use App\Models\Person;

use App\Models\Document;

use App\Models\Config;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class ShowIdentification extends Component
{
    use WithFileUploads;

    public $documentfront;
    public $documentback;
    public $selfiedocument;
    public $config;

    public $user;
    
    public $person;

    public function __construct()
    {
        ini_set( 'upload_max_size' , '256M' );
        ini_set( 'post_max_size', '256M');
        ini_set( 'max_execution_time', '300' );
    }

    public function mount()
    {
        $this->config = Config::select('logomarca')->first();
        $this->user = Auth::user();

        $this->user->name = Str::limit($this->user->name, 15);

        $this->user->email = Str::limit($this->user->email, 15);

        $this->person = Person::where('user_id', $this->user->id)->first();

        $this->document = Document::where('user_id', $this->user->id)->first();
    }

    public function save()
    {
        $this->validate([
            'documentfront' => 'required',
            'documentback' => 'required',
            'selfiedocument' => 'required',
        ]);
        
        // Lógica para salvar os arquivos, por exemplo:
        // $this->documentFront->store('documents', 'public');
        // $this->documentBack->store('documents', 'public');
        // $this->selfieDocument->store('documents', 'public');

        // Feedback para o usuário
        session()->flash('message', 'Documentos carregados com sucesso!');
    }

    public function render()
    {
        return view('livewire.show-identification')->layout('layouts.identification');
    }
}
