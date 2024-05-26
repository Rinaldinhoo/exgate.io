<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $table = 'wallet';

    protected $fillable = [
        'person_id',
        'amount',
        'amountusdt',
        'amountbrl',
        'amountmargem',
        'amountcpa',
        'cpatotal',
        'isoperated'
    ];
}
