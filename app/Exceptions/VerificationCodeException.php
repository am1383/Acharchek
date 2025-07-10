<?php

namespace App\Exceptions;

use App\Constants\MessageCode;
use App\Core\Services\Contracts\ResponseServiceInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VerificationCodeException extends Exception
{
    public function __construct()
    {
        parent::__construct();
    }

    public function render(Request $request): JsonResponse
    {
        $responseService = app(ResponseServiceInterface::class);

        return response()->json($responseService
            ->result(
                false,
                null,
                MessageCode::ERROR_PHONE_VERIFICATION_100
            )
        );
    }
}
