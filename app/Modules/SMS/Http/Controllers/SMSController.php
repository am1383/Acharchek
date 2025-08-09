<?php

namespace App\Modules\SMS\Http\Controllers;

use App\Modules\SMS\DTOs\SendSMSDTO;
use App\Modules\SMS\Requests\SendSMSRequest;
use App\Modules\SMS\Services\Contracts\SMSServiceInterface;

class SMSController
{
    public function __construct(private SMSServiceInterface $SMSService) {}

    public function send(SendSMSRequest $request)
    {
        $SMSDTO = new SendSMSDTO($request->validated());

    }
}
