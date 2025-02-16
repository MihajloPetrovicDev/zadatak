<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartController;
use App\Http\Controllers\SupplierController;

Route::get('/get-all-suppliers', [SupplierController::class, 'getAllSuppliers']);

Route::patch('/change-supplier-name', [SupplierController::class, 'changeSupplierName']);

Route::delete('/delete-supplier/{supplierId}', [SupplierController::class, 'deleteSupplier']);

Route::get('/get-all-parts', [PartController::class, 'getAllParts']);

Route::get('/get-supplier-parts/{supplierId}', [PartController::class, 'getSupplierParts']);

Route::patch('/update-part', [PartController::class, 'updatePart']);

Route::delete('/delete-part/{partId}', [PartController::class, 'deletePart']);