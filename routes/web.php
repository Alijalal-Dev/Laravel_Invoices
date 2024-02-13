<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\InvoiceAchiveController;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
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
Auth::routes();




Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('invoices',InvoicesController::class);
Route::resource('sections',SectionsController::class);
Route::resource('products',ProductsController::class);
Route::resource('InvoiceAttachments', 'App\Http\Controllers\InvoiceAttachmentsController');

Route::get('/edit_invoice/{id}',  [InvoicesController::class, 'edit']);//edit invoices


//get products of section via ajax 
Route::get('/section/{id}', [InvoicesController::class, 'getproducts']); 

Route::get('InvoicesDetails/{id}', [InvoicesDetailsController::class, 'edit']);

//3amaliyat show
Route::get('/Status_show/{id}', [InvoicesController::class, 'show'])->name('Status_show');
//3amaliyat update
Route::post('/Status_Update/{id}', [InvoicesController::class, 'Status_Update'])->name('Status_Update');

Route::get('Invoice_Paid',[InvoicesController::class, 'Invoice_Paid']);

Route::get('Invoice_UnPaid',[InvoicesController::class, 'Invoice_UnPaid']);

Route::get('Invoice_Partial',[InvoicesController::class, 'Invoice_Partial']);

Route::resource('Archive', 'App\Http\Controllers\InvoiceAchiveController');
//lprint dyal invoice
Route::get('Print_invoice/{id}',[InvoicesController::class, 'Print_invoice']);


//export invoices as excel
Route::get('export_invoices', [InvoicesController::class, 'export']);
//route dyal 3 buuton detailsinvoices
Route::get('download/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'get_file']);

Route::get('View_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'open_file']);

Route::post('delete_file', [InvoicesDetailsController::class, 'destroy'])->name('delete_file');

//user roles 
//permission
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles','App\Http\Controllers\RoleController');
    Route::resource('users','App\Http\Controllers\UserController');
    });
//ta9arir dyal invoices
Route::get('invoices_report', 'App\Http\Controllers\Invoices_Report@index');
Route::post('Search_invoices', 'App\Http\Controllers\Invoices_Report@Search_invoices');
//ta9arir dyal costumers
Route::get('customers_report', 'App\Http\Controllers\Customers_Report@index');
Route::post('Search_customers', 'App\Http\Controllers\Customers_Report@Search_customers');
//Read of all notifications 
Route::get('MarkAsRead_all','App\Http\Controllers\InvoicesController@MarkAsRead_all');
//show profile
Route::get('/show_profile/{id}', 'App\Http\Controllers\UserController@show_profile')->name('show_profile');
//search bar input main-header
Route::get('/searchPage','App\Http\Controllers\InvoicesController@searchPage')->name('searchPage');

Route::get('/{page}', 'App\Http\Controllers\AdminController@index');