<?php

namespace App\Modules\SMS\Http\Controllers;

use App\Modules\SMS\DTOs\SendSMSDTO;
use App\Modules\SMS\Requests\SendSMSRequest;
use App\Modules\SMS\Resources\SMSResource;
use App\Modules\SMS\Services\Contracts\SMSServiceInterface;

class SMSController
{
    public function __construct(private SMSServiceInterface $SMSService) {}

    public function send(SendSMSRequest $request): SMSResource
    {
        $SMSDTO = new SendSMSDTO($request->validated());

        return new SMSResource($this->SMSService
            ->send($SMSDTO->phone, $SMSDTO->hash_link));
    }
}
