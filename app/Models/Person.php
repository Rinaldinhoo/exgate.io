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
        'address',
        'user_id',
        'email_verified',
        'isverifieddocument'
    ];

    public function wallet() {
        return $this->hasOne(Wallet::class);
    }

    public function getEmailObfuscatedAttribute()
{
    $email = $this->email;
    $parts = explode('@', $email);

    if (count($parts) === 2) {
        $name = $parts[0];
        $domain = $parts[1];
        
        // Mostra o primeiro caractere do nome e um único asterisco
        $nameObfuscated = substr($name, 0, 1) . '*';
        
        // Obfusca o domínio mantendo a extensão
        $domainExtension = substr($domain, strrpos($domain, '.'));
        $domainObfuscated = '***' . $domainExtension;

        return $nameObfuscated . '@' . $domainObfuscated;
    }

    return $email; // Retorna o e-mail original se não estiver no formato esperado
}


    public function getPhoneObfuscatedAttribute()
    {
        $phone = $this->phone; // Suponha que $phone seja algo como '12345600'
        
        // Extraia partes específicas do número de telefone
        $prefix = substr($phone, 0, 2); // Pega os dois primeiros dígitos
        $suffix = substr($phone, -2);   // Pega os dois últimos dígitos
        
        // Monta o telefone com a máscara desejada
        $phoneObfuscated = $prefix . ' **-**' . $suffix;
        
        return $phoneObfuscated;
    }
    
}
