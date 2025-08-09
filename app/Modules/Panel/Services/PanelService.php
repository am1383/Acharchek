<?php

namespace App\Modules\Panel\Services;

use App\Constants\MessageCode;
use App\Core\Repositories\Contracts\UserRepositoryInterface;
use App\Modules\Panel\Services\Contracts\PanelServiceInterface;
use App\Modules\Auth\Models\User;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Database\Eloquent\Collection;

class PanelService implements PanelServiceInterface
{
    public function __construct(
        private PanelServiceInterface $panelService,
        private UserRepositoryInterface $userRepository,
    ) {}

    public function getUserPanelInfo(string $apiToken): array
    {
        $user = $this->userRepository
            ->findByApiToken($apiToken, ['id', 'phone']);

        $userInformation = $user->information()
            ->first(['last_vd', 'days', 'active', 'ban', 'sms_credit']);

        if (! $userInformation) {
            $user->information()->create(['phone' => $user->phone]);

            return [
                'status' => false,
                'message' => MessageCode::messageText(MessageCode::ERROR_BUSINESS_100),
                'message_code' => MessageCode::ERROR_BUSINESS_100,
            ];
        }

        return [
            'status' => true,
            'data' => $this->formatUserPanelData($user, $userInformation),
        ];
    }

    private function formatUserPanelData(User $user, $userInformation): array
    {
        return [
            'user_id' => $user->id,
            'active' => $userInformation->computeIsActive(),
            'expire_date' => $userInformation->panelExpireDate(),
            '_expire_date' => $userInformation->_panelExpireDate(),
            'remain_days' => max($userInformation->remainDays(), 0),
            'ban' => $userInformation->isBan(),
            'disabled' => $userInformation->accountDisabled(),
            'sms_credit' => $userInformation->sms_credit,
        ];
    }

    public function getUserPanelService(string $apiToken): array
    {
        $user = $this->userRepository
            ->findByApiToken($apiToken, ['id']);

        $services = $user->services()->get();

        $result = $this->prepareServiceResult($services);

        return [
            'status' => true,
            'data' => $this->formatUserPanelServiceData($result),
        ];
    }

    private function formatUserPanelServiceData(array $result): array
    {
        $now = Verta::now();

        return [
            'services' => $result,
            'date' => [
                'full' => $now->formatDate(),
                'pretty' => prettyDate($now->formatDate()),
                'year' => $now->year,
                'month' => $now->month,
                'day' => $now->day,
            ],
        ];
    }

    private function prepareServiceResult(Collection $services): array
    {
        $result = [];

        foreach ($services as $service) {
            array_push($result, [
                'id' => $service->id,
                'name' => $service->name,
            ]);
        }

        return $result;
    }
}
