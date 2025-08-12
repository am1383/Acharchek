<?php

namespace App\Modules\Customer\Services;

use App\Constants\MessageCode;
use App\Core\Repositories\Contracts\LoginTriesRepositoryInterface;
use App\Core\Repositories\Contracts\SettingRepositoryInterface;
use App\Modules\Customer\Repositories\Contracts\CustomerRepositoryInterface;
use App\Modules\Customer\Repositories\Contracts\CustomerSecretRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CustomerService implements CustomerServiceInterface
{
    public function __construct(
        private CustomerRepositoryInterface $customerRepository,
        private LoginTriesRepositoryInterface $loginTriesRepository,
        private CustomerSecretRepositoryInterface $customerSecretRepository,
        private SettingRepositoryInterface $settingRepository,
    ) {}

    public function tryEnter(string $phoneNumber, string $hashLink): array
    {
        $this->customerRepository->customerIsExistOrFail($phoneNumber);

        $user = $this->loginTriesRepository
            ->findByPhoneNumberOrFail($phoneNumber, 1, ['id', 'sent_at']);

        $phoneDelay = (int) $this->settingRepository->findByKey('verify_phone_delay');

        if ($user) {
            $date = new Carbon($user->sent_at);
            $diffSeconds = $date->diffInSeconds(now());

            if ($diffSeconds > $phoneDelay) {
                $this->loginTriesRepository->updateOrFailById($user->id, [
                    'finished' => 1,
                ]);
            } else {
                $timeRemain = $phoneDelay - $diffSeconds;
                $message = 'شما به تازگی درخواست داده اید. ';
                $message .= $timeRemain.' ثانیه دیگر تلاش کنید.';

                return [
                    'status' => false,
                    'message' => $message,
                    'message_code' => 12,
                    'data' => [
                        'phone' => $phoneDelay,
                        'lock_time' => $timeRemain,
                    ],
                ];
            }
        }

        $verifyCode = $this->generateVerfiyCode();

        $SRES = sendAuthVerifyCodeMobile($phoneNumber, $verifyCode, $hashLink);

        $this->storeLoginTries($phoneDelay, $verifyCode);

        return [
            'status' => true,
            'data' => [
                'phone' => $phoneNumber,
                'lock_time' => $phoneDelay,
            ],
        ];
    }

    private function storeLoginTries(string $phoneNumber, string $verifyCode): void
    {
        $this->loginTriesRepository->create([
            'phone' => $phoneNumber,
            'verify_code' => $verifyCode,
            'sent_at' => now()->toDateTimeString(),
            'is_customer' => 1,
        ]);
    }

    private function generateVerfiyCode(): string
    {
        return rand(0, 9).rand(0, 9).
               rand(0, 9).rand(0, 9);
    }

    public function finalizeEnter(string $phoneNumber, string $verifyCode): array
    {
        $session = $this->loginTriesRepository
            ->findByPhoneNumberOrFail($phoneNumber, 1, ['id', 'sent_at']);

        $expireTime = (int) $this->settingRepository->findByKey('verify_phone_time');

        $sessionSentAt = $session->sent_at;
        $sessionDate = new Carbon($sessionSentAt);
        $diffTime = $sessionDate->diffInSeconds(now());

        if ($diffTime > $expireTime + 5) {
            $this->loginTriesRepository
                ->updateOrFailById($session->id, ['finished' => 1]);

            return [
                'status' => true,
                'message' => MessageCode::messageText(MessageCode::ERROR_VERIFICATION_EXPIRATION_9),
                'message_code' => MessageCode::ERROR_VERIFICATION_EXPIRATION_9,
            ];
        }

        $realVerifyCode = $session->verify_code;

        if ($verifyCode !== $realVerifyCode) {
            return [
                'status' => false,
                'message' => MessageCode::messageText(MessageCode::ERROR_VERIFICATION_CODE_11),
                'message_code' => MessageCode::ERROR_VERIFICATION_CODE_11,
            ];
        }

        $this->loginTriesRepository
            ->updateOrFailById($session->id, ['finished' => 1]);

        $customer = $this->customerRepository
            ->findByPhoneNumberOrFail($phoneNumber, ['id']);

        $secret = $this->customerSecretRepository
            ->findByPhoneNumberOrFail($phoneNumber, ['secret']);

        if ($secret) {
            return [
                'status' => true,
                'data' => [
                    'customer_secret' => $secret->secret,
                ],
            ];
        }

        $secretValue = Str::random(70);

        $this->storeCustomerSecret($customer->id, $phoneNumber, $secretValue);

        return [
            'status' => true,
            'data' => [
                'customer_secret' => $secretValue,
            ],
        ];
    }

    private function storeCustomerSecret(int $customerId, string $phoneNumber, int $secretValue): void
    {
        $this->customerSecretRepository->create([
            'customer_id' => $customerId,
            'customer_phone' => $phoneNumber,
            'secret' => $secretValue,
        ]);
    }
}
