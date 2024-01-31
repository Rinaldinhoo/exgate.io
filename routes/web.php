<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\ShowLogin;
use App\Http\Livewire\ShowRegister;
use App\Http\Livewire\ShowWelcome;
use App\Http\Livewire\ShowWallet;
use App\Http\Livewire\ShowProfile;
use App\Http\Livewire\ShowSecurity;
use App\Http\Livewire\ShowIdentification;
use App\Http\Livewire\ShowCoupons;
use App\Http\Livewire\ShowTrade;

use App\Http\Controllers\LogOffController;





Route::get('/login', ShowLogin::class)->name('login');

Route::get('/register', ShowRegister::class)->name('register');

Route::middleware('auth')->group(function () {

    Route::get('/', ShowWelcome::class)->name('welcome');

    Route::get('/welcome', ShowWelcome::class)->name('welcome');

    Route::get('/wallet', ShowWallet::class)->name('wallet');

    Route::get('/profile', ShowProfile::class)->name('profile');

    Route::get('/security', ShowSecurity::class)->name('security');

    Route::get('/identification', ShowIdentification::class)->name('identification');

    Route::get('/coupons', ShowCoupons::class)->name('coupons');

    Route::get('/trade', ShowTrade::class)->name('trade');

    Route::get('/logoff', [LogOffController::class, 'logOff'])->name('logOff');

});
