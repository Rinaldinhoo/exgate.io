<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        
        'person_id',
        'price_open',
        'price_closed',
        'gain_loss',
        'amount',
        'executed',
        'total',
        'direction',
        'liquidation',
        'take_proft',
        'stop_loss',
        'typecoin',
        'typestop',
        'type',
        'status'
    ];
}
