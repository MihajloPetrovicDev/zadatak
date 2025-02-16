<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartController;
use App\Http\Controllers\SupplierController;

Route::get('/', function () {
    return view('home');
});

Route::get('/suppliers', [SupplierController::class, 'getSuppliersPage']);

Route::get('/parts', [PartController::class, 'getPartsPage']);

Route::get('/api/get-all-suppliers', [SupplierController::class, 'getAllSuppliers']);

Route::patch('/api/change-supplier-name', [SupplierController::class, 'changeSupplierName']);

Route::delete('/api/delete-supplier/{supplierId}', [SupplierController::class, 'deleteSupplier']);

Route::get('/api/get-all-parts', [PartController::class, 'getAllParts']);

Route::patch('/api/update-part', [PartController::class, 'updatePart']);