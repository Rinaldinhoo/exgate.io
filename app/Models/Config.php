<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $table = 'configs';

    protected $fillable = [
        'id',
        'min_withdraw',
        'max_withdraw',
        'margem',
        'min_deposit',
        'porcetagem',
        'endereco_carteira',
        'rede_deposito',
        'taxa',
        'msg_usdt',
        'msg_btc',
        'msg_brl',
        'enablebrl',
        'qrcode',
        'faviconwallet',
        'logomarca',
    ];
}
