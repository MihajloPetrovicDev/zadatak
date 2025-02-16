<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Condition;
use Exception;
use App\Models\Part;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Services\ErrorService;

class PartController extends Controller
{
    private $errorService;


    public function __construct(ErrorService $errorService)
    {
        $this->errorService = $errorService;
    }


    public function getPartsPage() {
        $partsResponse = $this->getAllParts();

        if($partsResponse->isSuccessful()) {
            $parts = json_decode($partsResponse->getContent(), true)['parts'] ?? [];
        }
        else {
            abort($partsResponse->getStatusCode());
        }

        $allSuppliers = Supplier::all();
        $allConditions = Condition::all();
        $allCategories = Category::all();

        return view('parts', compact('parts', 'allSuppliers', 'allConditions', 'allCategories'));
    }


    public function getAllParts() {
        try {
            $parts = Part::all();

            return response()->json([
                'parts' => $parts
            ], 200);
        }
        catch(Exception $e) { 
            return $this->errorService->handleExceptionJSON($e);
        }
    }


    public function updatePart(Request $request) {
        $requestData = $request->validate([
            'partId' => ['required', 'integer', 'min: 0', 'exists:parts,id'],
            'supplierId' => ['nullable', 'integer', 'min: 0', 'exists:suppliers,id'],
            'daysValid' => ['nullable', 'integer', 'min: 0'],
            'priority' => ['nullable', 'integer', 'min: 0'],
            'partNumber' => ['nullable', 'max: 255'],
            'partDescription' => ['required', 'max: 255'],
            'quantity' => ['nullable', 'integer', 'min: 0'],
            'price' => ['nullable', 'numeric', 'min: 0'],
            'conditionId' => ['nullable', 'integer', 'min: 0', 'exists:conditions,id'],
            'categoryId' => ['nullable', 'integer', 'min: 0', 'exists:categories,id'],
        ],
        [
            'partId.required' => 'Part ID required.',
            'partId.integer' => 'Invalid part ID.',
            'partId.min' => 'Invalid part ID.',
            'partId.exists' => 'Invalid part ID.',

            'supplierId.integer' => 'Invalid supplier ID.',
            'supplierId.min' => 'Invalid supplier ID.',
            'supplierId.exists' => 'Invalid supplier ID.',

            'daysValid.integer' => 'Invalid days valid format.',
            'daysValid.min' => 'Invalid days valid format.',

            'priority.integer' => 'Invalid priority format.',
            'priority.min' => 'Invalid priority format.',

            'partNumber.max' => "Part number can't be longer than 255 characters.",

            'partDescription.required' => 'Part description is required.',
            'partDescription.max' => "Part description can't be longer than 255 characters.",

            'quantity.integer' => 'Invalid quantity format.',
            'quantity.min' => 'Invalid quantity format.',

            'price.numeric' => 'Invalid price format.',
            'price.min' => 'Invalid price format.',

            'conditionId.integer' => 'Invalid condition ID.',
            'conditionId.min' => 'Invalid condition ID.',
            'conditionId.exists' => 'Invalid condition ID.',

            'categoryId.integer' => 'Invalid category ID.',
            'categoryId.min' => 'Invalid category ID.',
            'categoryId.exists' => 'Invalid category ID.',
        ]);

        try {
            $part = Part::find($requestData['partId']);

            $part->supplier_id = $requestData['supplierId'];
            $part->days_valid = $requestData['daysValid'];
            $part->priority = $requestData['priority'];
            $part->part_number = $requestData['partNumber'];
            $part->part_desc = $requestData['partDescription'];
            $part->quantity = $requestData['quantity'];
            $part->price = $requestData['price'];
            $part->condition_id = $requestData['conditionId'];
            $part->category_id = $requestData['categoryId'];

            $part->save();

            return response()->json([
                'message' => 'Part updated succesfully.',
            ], 200);
        }
        catch(Exception $e) {
            return $this->errorService->handleExceptionJSON($e);
        }
    }
}
