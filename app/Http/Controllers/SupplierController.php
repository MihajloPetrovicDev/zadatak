<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Part;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Services\ErrorService;
use Illuminate\Support\Facades\Response;

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
            'supplierId' => ['required', 'integer', 'min:0'],
        ],
        [
            'newSupplierName.required' => 'Supplier name is reqired.',
            'newSupplierName.max' => "Supplier name can't be longer than 255 characters.",
            'supplierId.required' => 'Supplier ID is reqired.',
            'supplierId.integer' => "Invalid supplier ID.",
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


    public function deleteSupplier($supplierId) {
        try{
            $supplier = Supplier::findOrFail($supplierId);
            $supplier->delete();

            return response()->json([
                'message' => 'Supplier deleted succesfully.'
            ], 200);
        }
        catch(Exception $e) { 
            return $this->errorService->handleExceptionJSON($e);
        }
    }


    public function downloadSupplierPartsCsv($supplierId) {
        try {
            $supplier = Supplier::findOrFail($supplierId);
            $parts = Part::where('supplier_id', $supplierId)->get();

            $formattedName = preg_replace('/[^a-zA-Z0-9]/', '_', $supplier->supplier_name);
            $dateTime = now()->format('Y_m_d-H_i');
            $fileName = $formattedName.'_'.$dateTime.'.csv';

            $newCsvFile = fopen('php://temp', 'r+');

            fputcsv($newCsvFile, ['supplier_name', 'days_valid', 'priority', 'part_number', 'part_desc', 'quantity', 'price', 'condition', 'category']);

            foreach($parts as $part) {
                fputcsv($newCsvFile, [
                    $part->supplier->supplier_name,
                    $part->days_valid,
                    $part->priority,
                    $part->part_number,
                    $part->part_desc,
                    $part->quantity,
                    $part->price,
                    $part->condition->condition_name,
                    $part->category->category_name
                ], ',', "\x1F");
                // \x1F is used as the enclosure char because it can be deleted troughout the whole file later without causing any issues,
                // effectively making it so that there are no enclosure chars in the csv file
            }

            rewind($newCsvFile);
            $csvData = stream_get_contents($newCsvFile);
            $csvData = str_replace("\x1F", "", $csvData);
            
            fclose($newCsvFile);

            return Response::make($csvData, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="'.$fileName.'"',
            ]);
        }
        catch(Exception $e) { 
            return $this->errorService->handleException($e);
        }
    }
}
