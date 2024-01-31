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
        'total',
        'direction',
        'take_proft',
        'stop_loss',
        'status'
    ];
}
