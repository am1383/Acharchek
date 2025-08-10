<?php

namespace App\Modules\SMS\Services;

use App\Core\Repositories\Contracts\LoginTriesRepositoryInterface;
use App\Core\Repositories\Contracts\SettingRepositoryInterface;
use App\Modules\SMS\Services\Contracts\SMSServiceInterface;
use Carbon\Carbon;

class SMSService implements SMSServiceInterface
{
    public function __construct(
        private SettingRepositoryInterface $settingRepository,
        private LoginTriesRepositoryInterface $loginTriesRepository,
    ) {}

    public function send(string $phoneNumber, string $hashLink): array
    {
        $verifyPhoneDelay = (int) $this->settingRepository
            ->findByKey('verify_phone_delay');

        if ($this->isSpecialUser($phoneNumber)) {
            return $this->prepareResultData($phoneNumber, $verifyPhoneDelay);
        }

        $lockResult = $this->isPhoneNumberLocked($phoneNumber, $verifyPhoneDelay);

        if ($lockResult !== null) {
            return $lockResult;
        }

        $verifyCode = $this->generateVerifyCode();
        sendAuthVerifyCodeMobile($phoneNumber, $verifyCode, $hashLink);

        $this->storeLoginTries($phoneNumber, $verifyCode);

        return $this->prepareResultData($phoneNumber, $verifyPhoneDelay);
    }

    private function isPhoneNumberLocked(string $phoneNumber, int $delayInSeconds): ?array
    {
        $record = $this->loginTriesRepository
            ->findByPhoneNumberOrFail($phoneNumber, ['id', 'sent_at']);

        $sentAt = new Carbon($record->sent_at);
        $elapsed = $sentAt->diffInSeconds(now());

        if ($elapsed > $delayInSeconds) {
            $this->loginTriesRepository->updateOrFailById($record->id, ['finished' => 1]);

            return null;
        }

        $remaining = $this->calculateRemainingTime($delayInSeconds, $elapsed);

        return [
            'ok' => false,
            'message' => 'شما به تازگی درخواست داده‌اید. '.$remaining.' ثانیه دیگر تلاش کنید.',
            'message_code' => 12,
            'data' => [
                'phone' => $phoneNumber,
                'lock_time' => $remaining,
            ],
        ];
    }

    private function calculateRemainingTime(int $delayInSeconds, int $elapsed): int
    {
        return $delayInSeconds - $elapsed;
    }

    public function storeLoginTries(string $phoneNumber, string $verifyCode): void
    {
        $this->loginTriesRepository->create([
            'phone' => $phoneNumber,
            'verify_code' => $verifyCode,
            'sent_at' => now()->toDateTimeString(),
            'is_customer' => 0,
        ]);
    }

    private function isSpecialUser(string $phoneNumber): bool
    {
        return $phoneNumber === '09194601434';
    }

    private function prepareResultData(string $phoneNumber, int $verifyPhoneDelay): array
    {
        return [
            'status' => true,
            'data' => [
                'phone' => $phoneNumber,
                'lock_time' => $verifyPhoneDelay,
            ],
        ];
    }

    private function generateVerifyCode(int $length = 4): string
    {
        return str_pad((string) random_int(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
    }
}
