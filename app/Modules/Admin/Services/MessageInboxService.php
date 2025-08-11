<?php

namespace App\Modules\Admin\Services;

use App\Core\Repositories\Contracts\UserRepositoryInterface;
use App\Modules\Admin\DTOs\StoreMessageInboxDTO;
use App\Modules\Admin\Repositories\Contracts\MessageInboxRepositoryInterface;
use App\Modules\Admin\Services\Contracts\MessageInboxServiceInterface;

class MessageInboxService implements MessageInboxServiceInterface
{
    public function __construct(
        private MessageInboxRepositoryInterface $messageInboxRepository,
        private UserRepositoryInterface $userRepository,
    ) {}

    public function store(StoreMessageInboxDTO $storeMessageInboxDTO): array
    {
        if ($storeMessageInboxDTO->target_users === 'all_users') {
            $users = $this->userRepository
                ->get(['id'])
                ->toArray();
        }

        $this->messageInboxRepository
            ->insert($this->prepareUsersArray($users, $storeMessageInboxDTO->title, $storeMessageInboxDTO->content));

        return [
            'status' => true,
            'message' => 'پیام مورد نظر برای '.count($users).' کاربر ارسال شد ',
        ];
    }

    private function prepareUsersArray(array $users, string $title, string $content): array
    {
        $data = [];

        foreach ($users as $user) {
            array_push($data, [
                'title' => $title,
                'content' => $content,
                'user_id' => $user->id,
            ]);
        }

        return $data;
    }
}
