<?php

namespace App\Modules\User\Services;

use App\Constants\MessageCode;
use App\Core\Models\User;
use App\Core\Repositories\Contracts\UserRepositoryInterface;
use App\Modules\Auth\Contexts\LocationContext;
use App\Modules\User\Services\Contracts\UserServiceInterface;

class UserService implements UserServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private LocationContext $locationContext
    ) {}

    public function getInformation(string $apiToken): User
    {
        return $this->userRepository
            ->findByApiToken($apiToken, ['id', 'first_name', 'last_name', 'phone', 'api_token', 'created_at']);
    }

    public function getSecondUserInformation(string $apiToken): array
    {
        $user = $this->userRepository
            ->findByApiToken($apiToken, ['id', 'first_name', 'last_name', 'phone']);

        $userInformation = $user->information()
            ->first(['business_name', 'province_id', 'city_id', 'address', 'avatar']);

        if ($error = $this->handleMissingInformation($userInformation, $user)) {
            return $error;
        }

        return [
            'status' => true,
            'data' => [
                'user' => $user->toArray(),
                'user_information' => $this->getUserInformation($userInformation->toArray()),
            ],
        ];
    }

    private function getUserInformation(array $userInformation): array
    {
        if ($userInformation['avatar'] == 'default.png') {
            $userInformation['avatar'] = null;
            $userInformation['avatar_link'] = null;
        } else {
            $userInformation['avatar_link'] = $userInformation['avatar'] ?
                asset('avatars/'.$userInformation['avatar']) : null;
        }

        return $userInformation;
    }

    public function getFullUserInformation(string $apiToken): array
    {
        $user = $this->userRepository
            ->findByApiToken($apiToken, ['id', 'api_token', 'first_name', 'last_name', 'api_token', 'creatd_at']);

        $userInformation = $user->information;

        if ($error = $this->handleMissingInformation($userInformation, $user)) {
            return $error;
        }

        $provinceId = $userInformation->province_id;
        $cityId = $userInformation->city_id;

        if ($provinceId !== 0) {
            $this->locationContext
                ->provinceRepository->findOrFail($provinceId, ['name']);
        }

        if ($cityId !== 0) {
            $this->locationContext
                ->cityRepository->findOrFail($cityId, ['name']);
        }

        $secondData = [
            'business_name' => $userInformation->business_name,
            'province_id' => $provinceId,
            'city_id' => $cityId,
            'province_name' => (isset($province) && $province) ? $province->name : null,
            'city_name' => (isset($city) && $city) ? $city->name : null,
            'address' => $userInformation->address,
            'avatar' => $userInformation->avatar == 'default.png' ? null : $userInformation->avatar,
            'avatar_link' => (($userInformation->avatar && $userInformation->avatar != 'default.png') ?
                asset('avatars/'.$userInformation->avatar) : null),

            'panel' => [
                'active' => $userInformation->computeIsActive(),
                'expire_date' => $userInformation->panelExpireDate(),
                '_expire_date' => $userInformation->_panelExpireDate(),
                'remain_days' => max($userInformation->remainDays(), 0),
                'ban' => $userInformation->isBan(),
                'disabled' => $userInformation->accountDisabled(),
                'sms_credit' => $userInformation->sms_credit,
            ],

            'util' => [
                'customers_count' => $user->customers()->count(),
                'checklists_count' => $user->checkLists()->count(),
            ],
        ];

        return [
            'status' => true,
            'data' => [
                'user' => $user->toArray(),
                'details' => $secondData,
            ],
        ];
    }

    private function handleMissingInformation($userInformation, User $user): ?array
    {
        if (! $userInformation) {
            $user->information()->create(['phone' => $user->phone]);

            return [
                'status' => false,
                'message' => MessageCode::messageText(MessageCode::ERROR_DATABASE_10),
                'message_code' => MessageCode::ERROR_DATABASE_10,
            ];
        }

        return null;
    }
}
