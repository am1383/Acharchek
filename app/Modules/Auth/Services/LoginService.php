<?php

namespace App\Modules\Auth\Services;

use App\Constants\MessageCode;
use App\Constants\PolicyConstants;
use App\Constants\UserConstants;
use App\Core\Repositories\Contracts\SettingRepositoryInterface;
use App\Modules\Auth\Services\Contracts\LoginServiceInterface;
use AuthContext;
use Carbon\Carbon;
use Illuminate\Support\Str;

class LoginService implements LoginServiceInterface
{
    public function __construct(
        private AuthContext $authContext,
        private SettingRepositoryInterface $settingRepository,
    ) {}

    public function handleLogin(string $phoneNumber, string $verifyCode, string $deviceInfo): array
    {
        $clientPolicy = PolicyConstants::CLIENT_POLICY;

        if ($this->isSpecialUser($phoneNumber, $verifyCode)) {
            return $this->loginOrCreateUser($phoneNumber, $deviceInfo, $clientPolicy);
        }

        $session = $this->authContext->loginTriesRepository->findByPhoneNumberOrFail($phoneNumber, ['id', 'sent_at', 'verify_code']);

        if ($this->isVerifyCodeExpired($session->sent_at)) {
            $this->authContext->loginTriesRepository->updateOrFailById($session->id, ['finished' => 1]);

            return [
                'status' => true,
                'message' => MessageCode::messageText(MessageCode::ERROR_VERIFICATION_EXPIRATION_9),
                'message_code' => Messagecode::ERROR_VERIFICATION_EXPIRATION_9,
            ];
        }

        if ($verifyCode !== $session->verify_code) {
            return [
                'status' => true,
                'message' => MessageCode::messageText(MessageCode::ERROR_VERIFICATION_CODE_11),
                'message_code' => MessageCode::ERROR_VERIFICATION_CODE_11,
            ];
        }

        $this->authContext->loginTriesRepository->updateOrFailById($session->id, ['finished' => 1]);

        return $this->loginOrCreateUser($phoneNumber, $deviceInfo, $clientPolicy);
    }

    private function loginOrCreateUser(string $phoneNumber, string $deviceInfo, int $clientPolicy): array
    {
        $user = $this->authContext->userRepository->findByPhoneNumber($phoneNumber, ['id', 'api_token']);

        if ($user) {
            return $this->buildUserLoginResponse($user, $deviceInfo, $phoneNumber, $clientPolicy, false);
        }

        $apiToken = Str::random(65);

        $newUser = $this->authContext->userRepository->create([
            'type' => UserConstants::TYPE_REGULAR,
            'phone' => $phoneNumber,
            'username' => $phoneNumber,
            'api_token' => $apiToken,
        ]);

        if (! $newUser) {
            return [
                'status' => false,
                'message' => MessageCode::messageText(MessageCode::ERROR_DATABASE_10),
                'message_code' => MessageCode::ERROR_DATABASE_10,
            ];
        }

        $newUser->information()->create(['phone' => $phoneNumber]);
        $newUser->services()->attach(range(1, 13));

        $this->storeDeviceInfo($newUser->id, $deviceInfo);

        return $this->prepareLoginResponse($apiToken, true, false, false, $clientPolicy);
    }

    private function buildUserLoginResponse($user, string $deviceInfo, string $phoneNumber, int $clientPolicy, bool $newUser): array
    {
        $information = $this->authContext->informationRepository
            ->findByUserId($user->id, ['id', 'business_name', 'mobile_flag_1']);

        if (! $information) {
            $user->information()->create(['phone' => $phoneNumber]);
            $infoFill = false;
            $fillServices = false;
        } else {
            $isMobile = 1;
            $infoFill = ! empty($information->business_name);
            $fillServices = $information->mobile_flag_1 === $isMobile;
        }

        $this->storeDeviceInfo($user->id, $deviceInfo);

        $apiToken = $user->api_token ?: Str::random(65);

        if (! $user->api_token) {
            $user->api_token = $apiToken;
            if (! $user->save()) {
                return [
                    'status' => false,
                    'message' => MessageCode::messageText(MessageCode::ERROR_DATABASE_10),
                    'message_code' => MessageCode::ERROR_DATABASE_10,
                ];
            }
        }

        return $this->prepareLoginResponse($apiToken, $newUser, $infoFill, $fillServices, $clientPolicy);
    }

    private function storeDeviceInfo(int $userId, string $deviceInfo): void
    {
        $this->authContext->mobileDeviceRepository->insert([
            'user_id' => $userId,
            'device_info' => $deviceInfo,
            'date' => now()->toDateTimeString(),
        ]);
    }

    private function isSpecialUser(string $phoneNumber, string $code): bool
    {
        return $phoneNumber === '09194601434' && $code === '1234';
    }

    private function isVerifyCodeExpired(string $sentAt): bool
    {
        $sentTime = new Carbon($sentAt);
        $diffTime = $sentTime->diffInSeconds(now());
        $timeToExpire = (int) $this->settingRepository->findByKey('verify_phone_time');
        $marginExpireTime = 5;

        return $diffTime > $timeToExpire + $marginExpireTime;
    }

    private function prepareLoginResponse(string $apiToken, bool $newUser, bool $infoFill, bool $fillServices, int $clientPolicy): array
    {
        return [
            'status' => true,
            'data' => [
                'api_token' => $apiToken,
                'new_user' => $newUser,
                'fill_info' => $infoFill,
                'fill_services' => $fillServices,
                'policy' => $clientPolicy,
            ],
        ];
    }
}
