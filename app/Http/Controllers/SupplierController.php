<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Services\ErrorService;
use Exception;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    private $errorService;


    public function __construct(ErrorService $errorService)
    {
        $this->errorService = $errorService;
    }


    public function getSuppliersPage() {
        $suppliersResponse = $this->getAllSuppliers();

        if($suppliersResponse->isSuccessful()) {
            $suppliers = json_decode($suppliersResponse->getContent(), true)['suppliers'] ?? [];
        }
        else {
            abort($suppliersResponse->getStatusCode());
        }

        return view('suppliers', compact('suppliers'));
    }


    public function getAllSuppliers() {
        try {
            $suppliers = Supplier::all();

            return response()->json([
                'suppliers' => $suppliers,
            ], 200);
        }
        catch(Exception $e) { 
            return $this->errorService->handleExceptionJSON($e);
        }
    }


    public function changeSupplierName(Request $request) {
        $requestData = $request->validate([
            'newSupplierName' => ['required', 'max: 255'],
            'supplierId' => ['required', 'int', 'min:0'],
        ],
        [
            'newSupplierName.required' => 'Supplier name is reqired.',
            'newSupplierName.max' => "Supplier name can't be longer than 255 characters.",
            'supplierId.required' => 'Supplier ID is reqired.',
            'supplierId.int' => "Invalid supplier ID.",
            'supplierId.min' => "Invalid supplier ID."
        ]);

        try {
            $supplier = Supplier::findOrFail($requestData['supplierId']);

            $supplier->supplier_name = $requestData['newSupplierName'];
            $supplier->save();

            return response()->json([
                'message' => 'Supplier name changed succesfully.'
            ], 200);
        }
        catch(Exception $e) { 
            return $this->errorService->handleExceptionJSON($e);
        }
    }
}
