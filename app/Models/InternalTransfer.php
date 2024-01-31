<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalTransfer extends Model
{
    use HasFactory;

    protected $table = 'internal_transfer';

    protected $fillable = [
        'whallet_sender_id',
        'whallet_destination_id',
        'amount',
        'status'
    ];

}
