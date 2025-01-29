<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class BaseService
{
    protected function logError(\Exception $e): void
    {
        Log::error($e->getMessage(),[
            'trace' => $e->getTraceAsString()
        ]);
    }
    protected function handleResponse($status,$code,$data = [],$message = "success"): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => $status,
            'data' => $data,
            'message' => $message,
        ],$code);
    }
}
