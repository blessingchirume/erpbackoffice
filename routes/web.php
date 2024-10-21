<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MethodController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {
        Auth::routes();

        Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth');

        Route::get('/tenants/register', [TenantController::class, 'register'])->name('tenant.register');

        Route::get('/tenants/register/success', [TenantController::class, 'success'])->name('tenant.register.success');

        Route::post('/tenants/register', [TenantController::class, 'store'])->name('tenant.register');

        Route::group(['middleware' => 'auth'], function () {

            Route::resources([
                'users' => UserController::class,
                'providers' => ProviderController::class,
                'inventory/products' => ProductController::class,
                'clients' => ClientController::class,
                'inventory/categories' => ProductCategoryController::class,
                'transactions/transfer' => TransferController::class,
                'methods' => MethodController::class,
            ]);

            Route::resource('transactions', TransactionController::class)->except(['create', 'show']);
            Route::get('transactions/stats/{year?}/{month?}/{day?}', [TransactionController::class, 'stats'])->name('transactions.stats');
            Route::get('transactions/{type}', [TransactionController::class, 'type'])->name('transactions.type');
            Route::get('transactions/{type}/create', [TransactionController::class, 'create'])->name('transactions.create');
            Route::get('transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');

            Route::get('inventory/stats/{year?}/{month?}/{day?}', [InventoryController::class, 'stats'])->name('inventory.stats');
            Route::resource('inventory/receipts', ReceiptController::class)->except(['edit', 'update']);
            Route::get('inventory/receipts/{receipt}/finalize', [ReceiptController::class, 'finalize'])->name('receipts.finalize');
            Route::get('inventory/receipts/{receipt}/product/add', [ReceiptController::class, 'addproduct'])->name('receipts.product.add');
            Route::get('inventory/receipts/{receipt}/product/{receivedproduct}/edit', [ReceiptController::class, 'editproduct'])->name('receipts.product.edit');
            Route::post('inventory/receipts/{receipt}/product', [ReceiptController::class, 'storeproduct'])->name('receipts.product.store');
            Route::match(['put', 'patch'], 'inventory/receipts/{receipt}/product/{receivedproduct}', [ReceiptController::class, 'updateproduct'])->name('receipts.product.update');
            Route::delete('inventory/receipts/{receipt}/product/{receivedproduct}', [ReceiptController::class, 'destroyproduct'])->name('receipts.product.destroy');

            Route::resource('sales', SaleController::class)->except(['edit', 'update']);
            Route::get('sales/{sale}/finalize', [SaleController::class, 'finalize'])->name('sales.finalize');
            Route::get('sales/{sale}/product/add', [SaleController::class, 'addproduct'])->name('sales.product.add');
            Route::get('sales/{sale}/product/{soldproduct}/edit', [SaleController::class, 'editproduct'])->name('sales.product.edit');
            Route::post('sales/{sale}/product', [SaleController::class, 'storeproduct'])->name('sales.product.store');
            Route::match(['put', 'patch'], 'sales/{sale}/product/{soldproduct}', [SaleController::class, 'updateproduct'])->name('sales.product.update');
            Route::delete('sales/{sale}/product/{soldproduct}', [SaleController::class, 'destroyproduct'])->name('sales.product.destroy');

            Route::get('clients/{client}/transactions/add', [ClientController::class, 'addtransaction'])->name('clients.transactions.add');

            Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::match(['put', 'patch'], 'profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::match(['put', 'patch'], 'profile/password', [ProfileController::class, 'password'])->name('profile.password');
           
        });



        Route::group(['middleware' => 'auth'], function () {
            Route::get('icons', [PageController::class, 'icons'])->name('pages.icons');
            Route::get('notifications', [PageController::class, 'notifications'])->name('pages.notifications');
            Route::get('tables', [PageController::class, 'tables'])->name('pages.tables');
            Route::get('typography', [PageController::class, 'typography'])->name('pages.typography');
        });
    });
}
