<?php

use App\Http\Controllers\Catalogos\AccountClassController;
use App\Http\Controllers\Catalogos\AccountTypeBanksController;
use App\Http\Controllers\Catalogos\AfpCommissionTypeController;
use App\Http\Controllers\Catalogos\AfpTypeController;
use App\Http\Controllers\Catalogos\BankTypeController;
use App\Http\Controllers\Catalogos\CardTypeController;
use App\Http\Controllers\Catalogos\CurrencyController;
use App\Http\Controllers\Catalogos\DocumentTypeController;
use App\Http\Controllers\Catalogos\MobileOperatorController;
use App\Http\Controllers\Catalogos\QuoteProviderController;
use App\Http\Controllers\Catalogos\TipoRedCriptoController;
use App\Http\Controllers\Catalogos\WorkerTypeController;
use App\Http\Controllers\Entidades\EntityController;
use App\Http\Controllers\Entidades\EntityTypeController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

Route::resource('payments', PaymentController::class);

// Rutas para Catalogos ---------------------------------------------------------------------------------------------------------------------------
Route::resource('currencies', CurrencyController::class);
Route::resource('card_types', CardTypeController::class);
Route::resource('mobile_operators', MobileOperatorController::class);
Route::resource('account_classes', AccountClassController::class);
Route::resource('account_types_banks', AccountTypeBanksController::class);
Route::resource('bank_types', BankTypeController::class);
Route::resource('document_types', DocumentTypeController::class);
Route::resource('quote_providers', QuoteProviderController::class);
Route::resource('tipo_red_cripto', TipoRedCriptoController::class);
Route::resource('worker_types', WorkerTypeController::class);
Route::resource('afp_types', AfpTypeController::class);
Route::resource('afp_commission_types', AfpCommissionTypeController::class);
//----------------------------------------------------------------------------------------------------------------------------

// Rutas para Entidades -----------------------------------------------------------------------------------------------
Route::resource('entities', EntityController::class);
Route::resource('entities.types', EntityTypeController::class)->except(['show']);

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
