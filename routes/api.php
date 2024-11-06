<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ReceiptController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\SaleController;
use App\Http\Controllers\Api\TenantController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClientController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MethodController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\CurrencyController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/login', [AuthController::class, 'authenticate']);

Route::get('/tenant/{code}', [TenantController::class, 'Get']);

Route::post('/register', [AuthController::class, 'register']);

Route::post('/forgot-password', [AuthController::class, 'passwordReset']);

Route::group(['middleware' => ['auth:api', 'database']], function () {

    Route::resources([
        'users' => UserController::class,
        'providers' => ProviderController::class,
        'inventory/products' => ProductController::class,
        'clients' => ClientController::class,
        // 'inventory/categories' => ApplicationController::class,
        'transactions/transfer' => TransferController::class,
        'methods' => MethodController::class,
        'currencies' => CurrencyController::class,
    ]);

    Route::prefix('account')->group(function () {
        Route::patch('update', [AuthController::class, 'update']);
        Route::patch('delete', [AuthController::class, 'delete']);
    });

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
    Route::post('sales/transact', [SaleController::class, 'store'])->name('sales.transact');

    Route::get('sales/{sale}/finalize', [SaleController::class, 'finalize'])->name('sales.finalize');
    Route::get('sales/{sale}/product/add', [SaleController::class, 'addproduct'])->name('sales.product.add');
    Route::get('sales/{sale}/product/{soldproduct}/edit', [SaleController::class, 'editproduct'])->name('sales.product.edit');
    Route::post('sales/{sale}/product', [SaleController::class, 'storeproduct'])->name('sales.product.store');
    Route::match(['put', 'patch'], 'sales/{sale}/product/{soldproduct}', [SaleController::class, 'updateproduct'])->name('sales.product.update');
    Route::delete('sales/{sale}/product/{soldproduct}', [SaleController::class, 'destroyproduct'])->name('sales.product.destroy');

    Route::get('clients/{client}/transactions/add', [ClientController::class, 'addtransaction'])->name('clients.transactions.add');

    Route::prefix('reports')->group(function () {
        Route::get('sales/{start}/{end}', [ReportController::class, 'SalesReport'])->name('reports.sales');
    });

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::match(['put', 'patch'], 'profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::match(['put', 'patch'], 'profile/password', [ProfileController::class, 'password'])->name('profile.password');
});
