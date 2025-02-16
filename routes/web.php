<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartController;
use App\Http\Controllers\SupplierController;

Route::get('/', function () {
    return view('home');
});

Route::get('/suppliers', [SupplierController::class, 'getSuppliersPage']);

Route::get('/parts', [PartController::class, 'getAllPartsPage']);

Route::get('/supplier-parts/{supplierId}', [PartController::class, 'getSupplierPartsPage']);