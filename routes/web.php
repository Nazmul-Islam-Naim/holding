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

        Route::get('deposits/index', [DepositController::class, 'create'])->name('deposits.index'); //un used
        Route::get('deposits/create/{id}', [DepositController::class, 'create'])->name('deposits.create');
        Route::post('deposits/store/{id}', [DepositController::class, 'store'])->name('deposits.store');
        Route::get('deposits/edit/{id}', [DepositController::class, 'edit'])->name('deposits.edit'); //un used
        Route::post('deposits/update/{id}', [DepositController::class, 'update'])->name('deposits.update'); //un used
        Route::delete('deposits/destroy/{id}', [DepositController::class, 'destroy'])->name('deposits.destroy'); //un used

        Route::get('withdraws/index', [WithdrawController::class, 'create'])->name('withdraws.index'); //un used
        Route::get('withdraws/create/{id}', [WithdrawController::class, 'create'])->name('withdraws.create');
        Route::post('withdraws/store/{id}', [WithdrawController::class, 'store'])->name('withdraws.store');
        Route::get('withdraws/edit/{id}', [WithdrawController::class, 'edit'])->name('withdraws.edit'); //un used
        Route::post('withdraws/update/{id}', [WithdrawController::class, 'update'])->name('withdraws.update'); //un used
        Route::delete('withdraws/destroy/{id}', [WithdrawController::class, 'destroy'])->name('withdraws.destroy'); //un used
        Route::post('withdraws/availableChequeNumbers', [WithdrawController::class, 'availableChequeNumbers'])->name('withdraws.availableChequeNumbers');

        Route::get('transfers/index', [TransferController::class, 'create'])->name('transfers.index'); //un used
        Route::get('transfers/create/{id}', [TransferController::class, 'create'])->name('transfers.create');
        Route::post('transfers/store/{id}', [TransferController::class, 'store'])->name('transfers.store');
        Route::get('transfers/edit/{id}', [TransferController::class, 'edit'])->name('transfers.edit'); //un used
        Route::post('transfers/update/{id}', [TransferController::class, 'update'])->name('transfers.update'); //un used
        Route::delete('transfers/destroy/{id}', [TransferController::class, 'destroy'])->name('transfers.destroy'); //un used

        Route::get('transactions', [TransactionController::class, 'transaction'])->name('transactions');
    });

});

require __DIR__.'/auth.php';
