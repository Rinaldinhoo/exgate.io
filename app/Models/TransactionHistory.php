<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionHistory extends Model
{
    use HasFactory;

    protected $table = 'transaction_history';

    protected $fillable = [
        
        'wallet_id',
        'amount',
        'type',
        'coin',
        'address',
        'status',
        'cpf',
        'user_id',
        'namecomplete',
        'bank',
        'agency',
        'currency',
        'codepix'
    ];
}
