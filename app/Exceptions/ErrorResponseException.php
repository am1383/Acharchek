<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class ErrorResponseException extends Exception
{
    public function __construct(
        private bool $status,
        private ?array $data = null,
        private ?string $messageCode = null,
        private ?string $message = null
    ) {
        parent::__construct($message);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'status' => $this->status,
            'data' => $this->data,
            'message_code' => $this->messageCode,
            'message' => $this->message,
        ]);
    }
}
