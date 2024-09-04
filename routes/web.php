<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\ShowLogin;
use App\Http\Livewire\ShowRegister;
use App\Http\Livewire\ShowWelcome;
use App\Http\Livewire\ShowWallet;
use App\Http\Livewire\ShowExchange;
use App\Http\Livewire\ShowProfile;
use App\Http\Livewire\ShowSecurity;
use App\Http\Livewire\ShowIdentification;
use App\Http\Livewire\ShowCoupons;
use App\Http\Livewire\ShowTrade;
use App\Http\Livewire\ShowTrocas;
use App\Http\Livewire\ShowForgot;
use App\Http\Livewire\ShowVerified;


use App\Http\Controllers\LogOffController;
use App\Http\Controllers\IdentificationController;




Route::get('/login', ShowLogin::class)->name('login');

Route::get('/reset', ShowForgot::class)->name('forgot');

Route::get('/verified', ShowVerified::class)->name('verified');

Route::get('/register', ShowRegister::class)->name('register');

Route::middleware(['auth', 'check-session'])->group(function () {

    Route::get('/', ShowWelcome::class)->name('welcome');

    Route::get('/welcome', ShowWelcome::class)->name('welcome');

    Route::get('/wallet', ShowWallet::class)->name('wallet');

    Route::get('/exchange', ShowExchange::class)->name('exchange');

    Route::get('/profile', ShowProfile::class)->name('profile');

    Route::get('/security', ShowSecurity::class)->name('security');
    Route::get('/security/checkfa', [ShowSecurity::class, 'checkfa'])->name('security.checkfa');
    Route::get('/security/excludecheckfa', [ShowSecurity::class, 'excludeCheckfa'])->name('security.excludeCheckfa');
    Route::get('/security/excludeaccount', [ShowSecurity::class, 'excludeAccount'])->name('security.excludeAccount');

    Route::get('/identification', ShowIdentification::class)->name('identification');
    Route::post('/upload-arquivos', [IdentificationController::class, 'save'])->name('upload.arquivos');

    Route::get('/coupons', ShowCoupons::class)->name('coupons');

    Route::get('/trade', ShowTrade::class)->name('trade');

    Route::get('/trocas', ShowTrocas::class)->name('trocas');

    Route::get('/logoff', [LogOffController::class, 'logOff'])->name('logOff');

});
