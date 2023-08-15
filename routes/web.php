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
use App\Http\Controllers\Product\ProductBrandController;
use App\Http\Controllers\Product\ProductCategoryController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\ProductUnitController;
use App\Http\Controllers\ProjectShare\BillGenerateController;
use App\Http\Controllers\ProjectShare\BillTypeController;
use App\Http\Controllers\Stock\StockController;
use App\Http\Controllers\ProjectShare\ShareCollectionController;
use App\Http\Controllers\Purchase\LocalPurchaseController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ProjectShare\ProjectShareController;
use App\Http\Controllers\ShareHolder\ShareHolderController;
use App\Http\Controllers\Stock\StockOutController;
use App\Http\Controllers\Supplier\LocalSupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Project\ProjectController;
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

    //****************** project **********//
    Route::prefix(config('app.project'))->group(function () {
        Route::resource('projects', ProjectController::class);
        Route::get('projects/ledger/{id}', [ProjectController::class, 'ledger'])->name('projects.ledger');
    });

    //****************** shareholder **********//
    Route::prefix(config('app.shareholder'))->group(function () {
        Route::resource('shareHolders', ShareHolderController::class);
        Route::get('shareHolders/ledger/{id}', [ShareHolderController::class, 'ledger'])->name('shareHolders.ledger');
    });

    //****************** share **********//
    Route::prefix(config('app.share'))->group(function () {
        Route::resource('projectShares', ProjectShareController::class);
        Route::resource('billTypes', BillTypeController::class);
        Route::resource('billGenerates', BillGenerateController::class);
        
        Route::get('shareCollections', [ShareCollectionController::class, 'index'])->name('shareCollections.index'); // un used
        Route::get('shareCollections/create/{id}', [ShareCollectionController::class, 'create'])->name('shareCollections.create');// un used
        Route::post('shareCollections/store/{id}', [ShareCollectionController::class, 'store'])->name('shareCollections.store');
        Route::get('shareCollections/{id}/edit', [ShareCollectionController::class, 'edit'])->name('shareCollections.edit'); 
        Route::put('shareCollections/update/{id}', [ShareCollectionController::class, 'update'])->name('shareCollections.update'); 
        Route::delete('shareCollections/destroy/{id}', [ShareCollectionController::class, 'destroy'])->name('shareCollections.destroy'); 
        Route::get('shareCollections/report', [ShareCollectionController::class, 'report'])->name('shareCollections.report'); 
        Route::get('shareCollections/amendment', [ShareCollectionController::class, 'amendment'])->name('shareCollections.amendment');
    });

    //****************** product **********//
    Route::prefix(config('app.product'))->group(function () {
        Route::resource('productCategories', ProductCategoryController::class);
        Route::resource('productUnits', ProductUnitController::class);
        Route::resource('productBrands', ProductBrandController::class);
        Route::resource('products', ProductController::class);

        Route::get('stocks/project', [StockController::class, 'projects'])->name('stocks.project');
        Route::get('stocks/project/products/{id}', [StockController::class, 'projectStock'])->name('stocks.project.products');
        Route::get('stocks/details/products', [StockController::class, 'stockDetails'])->name('stocks.details.products');
        Route::resource('products', ProductController::class);

        Route::resource('stockOuts', StockOutController::class);
        Route::get('stockOuts/product/details', [StockOutController::class, 'stockOutProductDetails'])->name('stockOuts.detials');
        Route::get('stockOuts/amendment', [StockOutController::class, 'list'])->name('stockOuts.list');
        Route::post('availableStockProduct', [StockOutController::class, 'availableStockProduct'])->name('availableStockProduct');
        Route::post('currentStock', [StockOutController::class, 'currentStock'])->name('currentStock');
    });

    //****************** purchase **********//
    Route::prefix(config('app.purchase'))->group(function () {
        Route::resource('localSuppliers', LocalSupplierController::class);
        Route::get('payableSuppliers', [LocalSupplierController::class, 'payableSuppliers'])->name('payableSuppliers');
        Route::get('paymentForm/{id}', [LocalSupplierController::class, 'paymentForm'])->name('paymentForm');
        Route::post('paymentStore', [LocalSupplierController::class, 'paymentStore'])->name('paymentStore');
        Route::get('paymentsReport', [LocalSupplierController::class, 'paymentsReport'])->name('paymentsReport');
        Route::get('paymentDueReport', [LocalSupplierController::class, 'paymentDueReport'])->name('paymentDueReport');

        
        Route::resource('localPurchases', LocalPurchaseController::class);
        Route::get('localPurchaseList/amendment', [LocalPurchaseController::class, 'list'])->name('localPurchaseList');
        Route::post('previousStock', [LocalPurchaseController::class, 'previousStock'])->name('previousStock');
    });
});

require __DIR__.'/auth.php';

//Clear Cache facade value:
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});
//Reoptimized class loader:
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});
//Route cache:
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});
//Clear Route cache:
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});
//Clear View cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});
//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});

Route::get('/foo', function () {
    Artisan::call('storage:link');
    return '<h1>Storage Created</h1>';
});
