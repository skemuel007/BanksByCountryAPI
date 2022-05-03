<?php

use App\Http\Controllers\BankController;
use App\Http\Controllers\CountryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['throttle:api'])->group([
    'prefix' => 'country'
], function($router) {

    Route::get('/', [CountryController::class, 'index']);
    Route::get('/{id}', [CountryController::class, 'show']);
});

Route::middleware(['throttle:api'])->group([
    'prefix' => 'bank'
], function($router) {
    Route::get('/', [BankController::class, 'index']);
    Route::get('/{id}', [BankController::class, 'show']);
    Route::post('/', [BankController::class, 'store']);
    Route::put('/{id}', [BankController::class, 'deactivateBank']);
});

Route::middleware(['throttle:api'])->group([
    'prefix' => 'bank_country'
], function($router) {
    Route::get('/', [BankController::class, 'banksByCountry']);
});
