<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MethodController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VatGroupController;
use Illuminate\Support\Facades\Artisan;
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

Auth::routes();


Route::get('/tenants/register', [CompanyController::class, 'create'])->name('tenant.register');

Route::get('/tenants/register/success', [TenantController::class, 'success'])->name('tenant.register.success');

Route::post('/tenants/register', [CompanyController::class, 'store'])->name('tenant.store');

Route::resource('users', UserController::class)->middleware('auth');

Route::group(['middleware' => ['auth', 'database']], function () {

    Route::resources([
        'roles' => RoleController::class,
        'providers' => ProviderController::class,
        'inventory/products' => ProductController::class,
        'clients' => ClientController::class,
        'inventory/categories' => ProductCategoryController::class,
        'transactions/transfer' => TransferController::class,
        'methods' => MethodController::class,
        'company/currencies' => CurrencyController::class,
        'company/vat-groups' => VatGroupController::class,
    ]);

    Route::resource('companies', CompanyController::class);

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/', function (){
        return redirect('/login');
    });

    Route::prefix('roles')->group(function () {
        Route::get('{role}/permission/create', [RoleController::class, 'createPermissions'])->name('roles.permissions.create');
        Route::post('{role}/permission/store', [RoleController::class, 'storePermissions'])->name('roles.permissions.store');

    });

    Route::resource('transactions', TransactionController::class)->except(['create', 'show']);
    Route::get('transactions/stats/{year?}/{month?}/{day?}', [TransactionController::class, 'stats'])->name('transactions.stats');
    Route::get('transactions/{type}', [TransactionController::class, 'type'])->name('transactions.type');
    Route::get('transactions/{type}/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::get('transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::get('transactions/{transaction}/show', [TransactionController::class, 'showPayment'])->name('payment.show');
    Route::post('transactions/{transaction}/finalize', [TransactionController::class, 'finalizePayment'])->name('payment.finalize');

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
    Route::get('sales/filter/{filter_type}', [SaleController::class, 'filter'])->name('sales.filter');
    Route::post('sales/employee', [SaleController::class, 'employeeSales'])->name('sales.employee');
    Route::post('sales/date', [SaleController::class, 'dailySales'])->name('sales.daily');

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

Route::get('/migrate', function (){
    return Artisan::call( 'migrate', [
        '--force' => true,
        '--database' => 'mysql',
        '--path' => 'database/migrations/tenant',
    ]);
});
