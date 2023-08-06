<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

trait ApiResponser
{
        public function successResponse($data, $code): JsonResponse
    {
        return response()->json($data, $code);
    }

    public function errorResponse($message, $code): JsonResponse
    {
        return response()->json([
            'error' => $message,
            'code' => $code
        ], $code);
    }

    protected function showAll(Collection $collection = null, $code = 200): JsonResponse
    {
        return $this->successResponse(['data' => $collection], $code);
    }

    protected function showOne(Model $model = null, $code = 200): JsonResponse
    {
            return $this->successResponse(['data' => $model], $code);
    }
}
