<?php

namespace App\Services\Response;

use App\Constants\MessageCode;
use App\Core\Services\Contracts\ResponseServiceInterface;

class ResponseService implements ResponseServiceInterface
{
    public function result(bool $status, ?array $data = null, ?string $messageCode = null, ?string $message = null): array
    {
        $result = ['ok' => $status];

        if (! is_null($data)) {
            $result['data'] = $data;
        }

        if ($messageCode) {
            $messageText = MessageCode::messageText($messageCode);
            $result['message'] = [
                'code' => $messageCode,
                'text' => $messageText,
                'user' => $message ?? $messageText,
            ];
        }

        return $result;
    }
}
