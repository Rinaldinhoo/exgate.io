<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gateway extends Model
{
    // Nome da tabela
    protected $table = 'gateway';

    // Colunas que podem ser preenchidas
    protected $fillable = ['client_id', 'client_secret'];

    // Desabilitar timestamps se não forem usados
    public $timestamps = false;
}
