<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $table = 'document';

    protected $fillable = [
        'user_id',
        'status',
        'documentfront',
        'documentback',
        'selfiedocument',
        'id',
        'observation',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
