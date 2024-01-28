<?php

namespace App\Helpers;
use Illuminate\Http\JsonResponse;

class ResponseHelper
{

    public static function make(string $status = 'success', array|object|null $data = null, string|null $msg = null, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $msg,
            'data' => $data
        ], $statusCode);
    }

}
