<?php

use App\Http\Controllers\AccountModule\AccountTypeController;
use App\Http\Controllers\AccountModule\BankAccountController;
use App\Http\Controllers\AccountModule\BankController;
use App\Http\Controllers\AccountModule\ChequeBookController;
use App\Http\Controllers\AccountModule\ChequeNumberController;
use App\Http\Controllers\AccountModule\DepositController;
use App\Http\Controllers\AccountModule\TransactionController;
use App\Http\Controllers\AccountModule\TransferController;
use App\Http\Controllers\AccountModule\WithdrawController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Voucher\SubTypeController;
use App\Http\Controllers\Voucher\TypeController;
use App\Http\Controllers\Voucher\VoucherController;
use App\Http\Controllers\Voucher\VoucherTransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [HomeController::class ,'index'])->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    
    //******** users part *******//
    Route::prefix(config('app.user'))->group(function () {
        Route::resource('user-list', UserController::class);
        Route::resource('user-role', RoleController::class);
    });
    
    // change password part
    Route::get('settings', [SettingController::class, 'index']);
    Route::put('update-user-password/{id}', [SettingController::class, 'updateUserPassword'])->name('update-user-password');
        
    //******** account module part *******//
    Route::prefix(config('app.account'))->group(function () {
        Route::resource('banks', BankController::class);
        Route::resource('accountTypes', AccountTypeController::class);
        Route::resource('bankAccounts', BankAccountController::class);
        Route::resource('chequeBooks', ChequeBookController::class);
        Route::resource('chequeNumbers', ChequeNumberController::class);

        Route::get('deposits', [DepositController::class, 'create'])->name('deposits.index'); //un used
        Route::get('deposits/create/{id}', [DepositController::class, 'create'])->name('deposits.create');
        Route::post('deposits/store/{id}', [DepositController::class, 'store'])->name('deposits.store');
        Route::get('deposits/{id}/edit', [DepositController::class, 'edit'])->name('deposits.edit'); //un used
        Route::put('deposits/update/{id}', [DepositController::class, 'update'])->name('deposits.update'); //un used
        Route::delete('deposits/destroy/{id}', [DepositController::class, 'destroy'])->name('deposits.destroy'); //un used

        Route::get('withdraws', [WithdrawController::class, 'create'])->name('withdraws.index'); //un used
        Route::get('withdraws/create/{id}', [WithdrawController::class, 'create'])->name('withdraws.create');
        Route::post('withdraws/store/{id}', [WithdrawController::class, 'store'])->name('withdraws.store');
        Route::get('withdraws/{id}/edit', [WithdrawController::class, 'edit'])->name('withdraws.edit'); //un used
        Route::put('withdraws/update/{id}', [WithdrawController::class, 'update'])->name('withdraws.update'); //un used
        Route::delete('withdraws/destroy/{id}', [WithdrawController::class, 'destroy'])->name('withdraws.destroy'); //un used
        Route::post('withdraws/availableChequeNumbers', [WithdrawController::class, 'availableChequeNumbers'])->name('withdraws.availableChequeNumbers');

        Route::get('transfers', [TransferController::class, 'create'])->name('transfers.index'); //un used
        Route::get('transfers/create/{id}', [TransferController::class, 'create'])->name('transfers.create');
        Route::post('transfers/store/{id}', [TransferController::class, 'store'])->name('transfers.store');
        Route::get('transfers/{id}/edit', [TransferController::class, 'edit'])->name('transfers.edit'); //un used
        Route::put('transfers/update/{id}', [TransferController::class, 'update'])->name('transfers.update'); //un used
        Route::delete('transfers/destroy/{id}', [TransferController::class, 'destroy'])->name('transfers.destroy'); //un used

        Route::get('transactions', [TransactionController::class, 'transaction'])->name('transactions');
    });

    //****************** voucher **********//
    Route::prefix(config('app.voucher'))->group(function () {
        Route::resource('types', TypeController::class);
        Route::resource('subTypes', SubTypeController::class);
        Route::resource('vouchers', VoucherController::class);
        Route::post('vouchers/subType', [VoucherController::class, 'subType'])->name('vouchers.subType');

        Route::get('transactions', [VoucherTransactionController::class, 'index'])->name('voucherTransaction.index'); //un used
        Route::get('transactions/create/{id}', [VoucherTransactionController::class, 'create'])->name('voucherTransaction.create');
        Route::post('transactions/store/{id}', [VoucherTransactionController::class, 'store'])->name('voucherTransaction.store');
        Route::get('transactions/{id}/edit', [VoucherTransactionController::class, 'edit'])->name('voucherTransaction.edit'); //un used
        Route::put('transactions/update/{id}', [VoucherTransactionController::class, 'update'])->name('voucherTransaction.update'); //un used
        Route::delete('transactions/destroy/{id}', [VoucherTransactionController::class, 'destroy'])->name('voucherTransaction.destroy'); //un used
        Route::get('transactions/receiveReport', [VoucherTransactionController::class, 'receiveReport'])->name('voucherTransaction.receiveReport');
        Route::get('transactions/paymentReport', [VoucherTransactionController::class, 'paymentReport'])->name('voucherTransaction.paymentReport');
    });


});

require __DIR__.'/auth.php';
