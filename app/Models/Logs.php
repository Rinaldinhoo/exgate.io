<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;

    protected $table = 'logs';

    protected $fillable = [
        'id',
        'logs',
        'models',
        'user_id'
    ];

    protected $casts = [
        'logs' => 'array',
    ];
}
