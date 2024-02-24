<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/getallinvoices', [InvoiceController::class, 'getAllInvoices']);

Route::get('/searchinvoice', [InvoiceController::class, 'searchInvoice']);

Route::get('/createinvoice', [InvoiceController::class, 'createInvoice']);

Route::get('/getallcustomers', [CustomerController::class, 'getAllCustomers']);

Route::get('/products', [ProductController::class, 'getAllProducts']);

Route::post('/addInvoice', [InvoiceController::class, 'addInvoice']);


