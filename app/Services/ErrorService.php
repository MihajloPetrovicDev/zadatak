<?php 

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;

class ErrorService {
    public function handleExceptionJSON(Exception $e) {
        Log::error('Error occurred', [
            'message' => $e->getMessage(),
            'exception' => $e,
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
        ]);

        return response()->json(['errors' => [
            'errors' => [
                'error' => [
                    'message' => $e->getMessage()
                ]
            ]
        ]], 500);
    }


    public function handleException(Exception $e) {
        Log::error('Error occurred', [
            'message' => $e->getMessage(),
            'exception' => $e,
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
        ]);

        return abort(500);
    }
}