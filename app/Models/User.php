<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'code',
        'last_login',
        'password',
        'sumcpalvl1',
        'sumcpalvl2',
        'aflevel1',
        'aflevel2',
        'is2fa',
        'code2fa',
        'temporary_password',
        'temporary_password_expires_at',
        'tokenreset',
        'tokenverified',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function person() {
        return $this->hasOne(Person::class);
    }

    public function getEmailObfuscatedAttribute()
    {
        $email = $this->email;
        $parts = explode('@', $email);
    
        if(count($parts) === 2) {
            $name = $parts[0];
            $domain = $parts[1];
            
            // Mostra o primeiro caractere do nome e um único asterisco
            $nameObfuscated = substr($name, 0, 1) . '*';
            
            // Obfusca o domínio mantendo a extensão
            $domainObfuscated = '***' . substr($domain, strrpos($domain, '.'));
    
            return $nameObfuscated . '@' . $domainObfuscated;
        }
    
        return $email; // Retorna o e-mail original se não estiver no formato esperado
    }
    
}
