<?php

namespace App\Modules\Auth\Services;

use App\Constants\Constants;
use App\Constants\MessageCode;
use App\Core\Services\Contracts\CacheServiceInterface;
use App\Core\Services\Contracts\RateLimitServiceInterface;
use App\Core\Services\Contracts\SMSServiceInterface;
use App\Events\NewLogin;
use App\Exceptions\ErrorResponseException;
use App\Helpers\ResponseHelper;
use App\Modules\Auth\DTOs\LoginDTO;
use App\Modules\Auth\DTOs\VerifyLoginDTO;
use App\Modules\Auth\Models\User;
use App\Modules\Auth\Repositories\Contracts\UserRepositoryInterface;
use App\Modules\Auth\Resources\LoginResource;
use App\Modules\Auth\Services\Contracts\LoginServiceInterface;
use Illuminate\Support\Facades\Auth;

class LoginService implements LoginServiceInterface
{
    public function __construct(
        private RateLimitServiceInterface $rateLimitService,
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

        return ResponseHelper::result(true, ['time_to_next' => $phoneVerificationDelay]);
    }

    public function verifyLogin(VerifyLoginDTO $verifyLoginDTO): array
    {
        $this->rateLimitService->isVerifyLoginRateLimited($verifyLoginDTO->ip, $verifyLoginDTO->phoneNumber, Constants::ERROR_RATE_LIMITER_100);

        $verificationCode = $this->cacheService->getVerificationCodeOrFail();

        $this->rateLimitService->rateLimitHitVerifyLogin($verifyLoginDTO->ip, $verifyLoginDTO->phoneNumber);

        $this->validateVerificationCodeOrFail($verificationCode, $verifyLoginDTO->verificationCode);

        $user = $this->userRepository->findByPhoneNumber($verifyLoginDTO->phoneNumber);

        $this->cacheService->forgetPhoneVerificationCode($verifyLoginDTO->phoneNumber);

        if (is_array($this->ensureUserIsExist($user, true))) {
            return $this->ensureUserIsExist($user, true);
        }

        $sessionKey = $this->generateRegisterSessionKey($verifyLoginDTO->phoneNumber, $verificationCode);

        $sessionData = $this->generateSessionData();

        $this->cacheService->putSessionKey($sessionKey, $sessionData);

        $data = $this->prepareUserInfo($sessionKey);

        return ResponseHelper::result(true, $data);
    }

    private function prepareUserInfo(string $sessionKey): array
    {
        return [
            'new_user' => true,
            'register_session_key' => $sessionKey,
        ];
    }

    private function generateSessionData(): array
    {
        return compact('phone');
    }

    private function generateRegisterSessionKey(string $phoneNumber, string $verificationCode): string
    {
        $randomDigits = str_pad((string) random_int(0, 99999999), 8, '0', STR_PAD_LEFT);

        return "register_{$phoneNumber}_{$verificationCode}_{$randomDigits}";
    }

    private function ensureUserIsExist(User $user, bool $isWeb): ?array
    {
        $data = [];

        if ($user) {
            $data = [
                'new_user' => false,
                'user_info' => new LoginResource($user),
            ];

            if ($isWeb) {
                Auth::login($user);
            }

            event(new NewLogin($user, $isWeb));

            return ResponseHelper::result(true, $data);
        }

        return null;
    }

    private function validateVerificationCodeOrFail(string $verificationCode, string $userVerificationCode): void
    {
        throw_if(
            $verificationCode !== $userVerificationCode,
            new ErrorResponseException(false, null, MessageCode::ERROR_PHONE_VERIFICATION_101)
        );
    }
}
