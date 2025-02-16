<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;

Route::get('/', function () {
    return view('home');
});

Route::get('/suppliers', [SupplierController::class, 'getSuppliersPage']);

Route::get('/products', [ProductController::class, 'getProductsPage']);

Route::get('/api/get-all-suppliers', [SupplierController::class, 'getAllSuppliers']);

Route::patch('/api/change-supplier-name', [SupplierController::class, 'changeSupplierName']);

Route::delete('/api/delete-supplier/{supplierId}', [SupplierController::class, 'deleteSupplier']);