<?php

namespace App\Exceptions;

use App\Core\Services\Contracts\ResponseServiceInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RateLimitException extends Exception
{
    public function __construct(
        private int $seconds,
        private string $messageCode,
        string $message
    ) {
        parent::__construct($message);
    }

    public function render(Request $request): JsonResponse
    {
        $responseService = app(ResponseServiceInterface::class);

        return response()->json(
            $responseService->result(
                false,
                ['seconds' => $this->seconds],
                $this->messageCode,
                $this->getMessage()
            ),
            429
        );
    }
}
