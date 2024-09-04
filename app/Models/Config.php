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
        'min_deposit',
        'endereco_carteira',
        'porcetagem',
        'margem',
        'rede_deposito',
        'taxa',
        'profit_rate',
        'operating_fee',
        'msg_usdt',
        'msg_btc',
        'msg_brl',
        'enablebrl',
        'liquidationpercent',
        'qrcode',
        'faviconwallet',
        'logomarca',
    ];
}
