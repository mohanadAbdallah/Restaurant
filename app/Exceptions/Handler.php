<?php

namespace App\Exceptions;

use App\Helpers\apiResponse;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

    }

    /**
     * Prepare a JSON response for the given exception.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function prepareJsonResponse($request, Throwable $e): JsonResponse
    {
        if ($e instanceof AuthenticationException) {
            return apiResponse::errorResponse('Authentication failed: Unauthenticated', 401);
        } elseif ($e instanceof AuthorizationException) {
            return apiResponse::errorResponse('Authorization failed: Unauthorized', 403);
        } elseif ($e instanceof NotFoundHttpException) {
            return apiResponse::errorResponse('Resource not found: Model not found', 404);
        } elseif ($e instanceof ValidationException) {
            return apiResponse::errorResponse('Validation failed', 422);
        } else {
            return apiResponse::errorResponse('Server error: An unexpected error occurred',500);
        }
    }

}
