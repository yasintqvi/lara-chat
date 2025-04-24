<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller
{
    /**
     * Return a standard JSON response.
     */
    public function baseResponse(
        mixed $data = null,
        ?string $message = null,
        int $code = Response::HTTP_OK
    ): JsonResponse {
        return response()->json([
            'status' => $code < Response::HTTP_BAD_REQUEST,
            'message' => is_null($message) ? __('messages.success') : $message,
            'data' => $data ?? [],
        ], $code);
    }
}
