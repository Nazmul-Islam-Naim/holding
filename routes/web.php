<?php

use App\Http\Controllers\AccountModule\AccountTypeController;
use App\Http\Controllers\AccountModule\BankAccountController;
use App\Http\Controllers\AccountModule\BankController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DesignationController;
use App\Models\AccountType;
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
    });

});

require __DIR__.'/auth.php';
