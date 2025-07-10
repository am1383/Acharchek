<?php

namespace App\Modules\Auth\Services;

use App\Core\Services\Contracts\CacheServiceInterface;
use App\Core\Services\Contracts\RateLimitServiceInterface;
use App\Core\Services\Contracts\ResponseServiceInterface;
use App\Core\Services\Contracts\SMSServiceInterface;
use App\Modules\Auth\DTOs\LoginDTO;
use App\Modules\Auth\DTOs\VerifyLoginDTO;
use App\Modules\Auth\Repositories\Contracts\UserRepositoryInterface;
use App\Modules\Auth\Services\Contracts\LoginServiceInterface;
use Constants;

class LoginService implements LoginServiceInterface
{
    public function __construct(
        private RateLimitServiceInterface $rateLimitService,
        private ResponseServiceInterface $responseService,
        private CacheServiceInterface $cacheService,
        private SMSServiceInterface $smsService,
        private UserRepositoryInterface $userRepository,
    ) {}

    public function handleLogin(LoginDTO $loginDTO): array
    {
        $this->rateLimitService->isRateLimited($loginDTO->ip, $loginDTO->phoneNumber);

        $verificationCode = $this->smsService->sendSMSVerificationCode();

        $phoneVerificationDelay = $this->cacheService
            ->putVerificationCode($loginDTO->phoneNumber, $verificationCode);

        $this->rateLimitService->rateLimitHitLogin();

        return $this->responseService
            ->result(true, ['time_to_next' => $phoneVerificationDelay]);
    }

    public function verifyLogin(VerifyLoginDTO $verifyLoginDTO)
    {
        $this->rateLimitService->isVerifyLoginRateLimited($verifyLoginDTO->ip, $verifyLoginDTO->phoneNumber, Constants::ERROR_RATE_LIMITER_100);

        $verificationCode = $this->cacheService->getVerificationCodeOrFail();

        $this->rateLimitService->rateLimitHitVerifyLogin($verifyLoginDTO->ip, $verifyLoginDTO->phoneNumber);

        $this->validateVerificationCodeOrFail($verificationCode, $verifyLoginDTO->verificationCode);

        $user = $this->userRepository->findByPhoneNumber($verifyLoginDTO->phoneNumber);

        $this->cacheService->forgetPhoneVerificationCode($verifyLoginDTO->phoneNumber);
    }

    private function validateVerificationCodeOrFail(string $verificationCode, string $userVerificationCode) {}
}
