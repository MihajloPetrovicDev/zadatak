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
            $this->errorService->logException($e);

            return response()->json(['errors' => [
                'errors' => [
                    'error' => [
                        'message' => $e->getMessage()
                    ]
                ]
            ]], 500);
        }
    }
}
