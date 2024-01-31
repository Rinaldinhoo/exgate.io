<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Api\UserController;
use App\Http\Api\CoinMarketcapController;
use App\Http\Api\PricingController;
use App\Http\Api\WalletController;

use App\Http\Api\BinanceController;
use App\Http\Api\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('cors')->group(function () {

    Route::apiResource('users', UserController::class);

   // Route::apiResource('pricing', PricingController::class);
   //Route::get('pricing', [CoinMarketcapController::Class, 'index'])->name('pricing');

    Route::apiResource('wallet', WalletController::class);

    Route::get('pricing', [BinanceController::class, 'index']);

    Route::get('last-pricing', [BinanceController::class, 'lastPricing']);

    Route::get('order-by-person-id', [OrderController::class, 'getOrderByPersonId']);

    Route::get('btc-usdt', [BinanceController::class, 'btcUsdtData']);

});