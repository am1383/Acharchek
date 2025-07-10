<?php

namespace App\Services\Response;

use App\Constants\MessageCode;
use App\Core\Services\Contracts\ResponseServiceInterface;

class ResponseService implements ResponseServiceInterface
{
    public function result(bool $status, ?array $data = null, ?string $messageCode = null, ?string $message = null): array
    {
        $result = ['ok' => $status];

        if (! is_null($messageCode)) {
            $messageText = MessageCode::messageText($messageCode);
            $userMessage = $message ?? $messageText;

            $result['message'] = [
                'code' => $messageCode,
                'text' => $messageText,
                'user' => $userMessage,
            ];
        }

        return $result;
    }
}
