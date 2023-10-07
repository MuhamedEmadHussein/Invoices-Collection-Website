<?php

use App\Http\Controllers\ArchieveController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\InvoicesReportController;
use App\Http\Controllers\CustomersReportController;
use App\Http\Controllers\InvoicesAttachmentsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


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
    return view('auth.register');
});
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['web', 'auth',config('jetstream.auth_session'),'verified', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){ //...
        
            Route::get('/dashboard', [HomeController::class,'index'])->name('index');
            Route::get('/markAsRead/{notification_id}/{invoice_id}',[HomeController::class,'markAsRead'])->name('markAsRead');
            Route::get('/markAsReadAll',[HomeController::class,'markAsReadAll'])->name('markAsReadAll');
            Route::resource('/products', ProductController::class);
            Route::resource('/categories', CategoryController::class);
            Route::resource('/roles',RoleController::class);
            Route::resource('/users',UserController::class);
            Route::resource('/invoices',InvoicesController::class);
            Route::resource('/archieve',ArchieveController::class);
            Route::resource('/invoice_attachments',InvoicesAttachmentsController::class);
            Route::resource('/InvoicesDetails',InvoicesDetailsController::class);
        
            Route::get('/category/{id}', [InvoicesController::class,'getProducts']);
            Route::get('/export_invoices', [InvoicesController::class,'export'])->name('export_invoices');
            Route::get('/showPaidInvoices',[InvoicesDetailsController::class,'showPaidInvoices'])->name('paid_invoices');
            Route::get('/showUnPaidInvoices',[InvoicesDetailsController::class,'showUnPaidInvoices'])->name('unpaid_invoices');
            Route::get('/showPartialPaidInvoices',[InvoicesDetailsController::class,'showPartialPaidInvoices'])->name('partial_paid_invoices');
            Route::get('download/{invoice_number}/{file_name}',[InvoicesDetailsController::class,'download_file'])->name('download');
            Route::get('View_file/{invoice_number}/{file_name}',[InvoicesDetailsController::class,'view_file'])->name('view_file');
            Route::get('print_invoice/{id}',[InvoicesController::class,'print_invoice'])->name('print_invoice');
            Route::get('show_payment/{id}',[InvoicesController::class,'show_payment_status'])->name('Status_show');
            Route::post('update_payment/{id}',[InvoicesController::class,'update_payment_status'])->name('Status_Update');
            Route::post('/delete_file',[InvoicesDetailsController::class,'destroy'])->name('delete_file');
            
            Route::get('/invoices_report', [InvoicesReportController::class,'index']);
            Route::post('/Search_invoices', [InvoicesReportController::class,'Search_invoices']);
            Route::get('/customers_report', [CustomersReportController::class,'index'])->name("customers_report");
            Route::post('/search_customers', [CustomersReportController::class,'search_customers']);
            
    });

    Route::post('/login', [LoginController::class, 'login'])->name('login');            
