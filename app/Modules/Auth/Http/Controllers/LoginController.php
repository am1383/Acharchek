<?php

namespace App\Modules\Auth\Http\Controllers;

use App\Core\Services\Contracts\CacheServiceInterface;
use App\Core\Services\Contracts\RateLimitServiceInterface;
use App\Core\Services\Contracts\ResponseServiceInterface;
use App\Core\Services\Contracts\SMSServiceInterface;
use App\Modules\Auth\DTOs\LoginDTO;
use App\Modules\Auth\Requests\LoginRequest;
use App\Modules\Auth\Resources\LoginResource;

class LoginController
{
    public function __construct(
        private RateLimitServiceInterface $rateLimitService,
        private ResponseServiceInterface $responseService,
        private CacheServiceInterface $cacheService,
        private SMSServiceInterface $smsService,
    ) {}

    public function login(LoginRequest $request): LoginResource
    {
        $loginDTO = LoginDTO::fromRequest($request->validated());

        $this->rateLimitService->isRateLimited($loginDTO->ip, $loginDTO->phoneNumber);

        $verificationCode = $this->smsService->sendSMSVerificationCode();

        $phoneVerificationDelay = $this->cacheService
            ->putVerificationCode($loginDTO->phoneNumber, $verificationCode);

        $this->rateLimitService->rateLimitHit();

        return new LoginResource($this->responseService
            ->result(true, ['time_to_next' => $phoneVerificationDelay]));
    }

    public function verifyLogin() {}
}
