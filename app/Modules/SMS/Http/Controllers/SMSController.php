<?php

namespace App\Modules\SMS\Http\Controllers;

use App\Modules\SMS\DTOs\SendSMSDTO;
use App\Modules\SMS\Requests\SendSMSRequest;
use App\Modules\SMS\Resources\SMSPriceInformationResource;
use App\Modules\SMS\Resources\SMSResource;
use App\Modules\SMS\Services\Contracts\SMSServiceInterface;

class SMSController
{
    public function __construct(private SMSServiceInterface $SMSService) {}

    public function send(SendSMSRequest $request): SMSResource
    {
        $dto = new SendSMSDTO($request->validated());

        return new SMSResource($this->SMSService
            ->send($dto->phone, $dto->hash_link));
    }

    public function priceInformation(): SMSPriceInformationResource
    {
        return new SMSPriceInformationResource($this->SMSService
            ->getPriceInformation());
    }
}
