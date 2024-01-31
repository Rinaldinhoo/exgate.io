<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table = 'persons';

    protected $fillable = [

        'name',
        'email',
        'phone',
        'user_id',
        'email_verified'
    ];

    public function wallet() {
        return $this->hasOne(Wallet::class);
    }
}
