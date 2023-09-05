<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class apiResponse
{
    public static function successResponse($data): JsonResponse
    {
        return response()->json($data);
    }

    public static function errorResponse($message, $code): JsonResponse
    {
        return response()->json([
            'error' => $message,
            'code' => $code
        ], $code);
    }
}
