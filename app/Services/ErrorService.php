<?php 

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ErrorService {
    public function logException(Exception $e) {
        Log::error('Error occurred', [
            'message' => $e->getMessage(),
            'exception' => $e,
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
            'user_id' => Auth::check() ? Auth::id() : null,
        ]);
    }
}