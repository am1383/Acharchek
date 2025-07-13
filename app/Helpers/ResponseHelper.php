<?php

namespace App\Helpers;

use App\Constants\MessageCode;

class ResponseHelper
{
    public static function result(bool $status, ?array $data = null, ?string $messageCode = null, ?string $message = null): array
    {
        $result = ['status' => $status];

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
