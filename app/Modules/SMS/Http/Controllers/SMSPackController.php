<?php

namespace App\Modules\SMS\Http\Controllers;

use App\Modules\SMS\DTOs\SMSPackDetailsDTO;
use App\Modules\SMS\DTOs\SMSPackDTO;
use App\Modules\SMS\Requests\SMSPackDetailsRequest;
use App\Modules\SMS\Requests\SMSPackRequest;
use App\Modules\SMS\Resources\SMSPackDetailsResource;
use App\Modules\SMS\Resources\SMSPackResource;
use App\Modules\SMS\Services\Contracts\SMSPackServiceInterface;

class SMSPackController
{
    public function __construct(private SMSPackServiceInterface $sMSPackService) {}

    public function show(SMSPackRequest $request): SMSPackResource
    {
        $smsPackDTO = new SMSPackDTO($request->header('AppVersion'));

        return new SMSPackResource($this->sMSPackService
            ->getSMSPacks($smsPackDTO->AppVersion));
    }

    public function details(SMSPackDetailsRequest $request): SMSPackDetailsResource
    {
        $smsPackDetailsDTO = new SMSPackDetailsDTO($request->validated());

        return new SMSPackDetailsResource($this->sMSPackService
            ->getDetailsById($smsPackDetailsDTO->id));
    }
}
