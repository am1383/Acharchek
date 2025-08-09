<?php

namespace App\Modules\Admin\Http\Controllers\Api;

use App\Modules\Admin\DTOs\StoreMessageInboxDTO;
use App\Modules\Admin\Requests\StoreMessageInboxRequest;
use App\Modules\Admin\Resources\MessageInboxResource;
use App\Modules\Admin\Services\Contracts\MessageInboxServiceInterface;

class MessageInboxController
{
    public function __construct(private MessageInboxServiceInterface $messageInboxService) {}

    public function store(StoreMessageInboxRequest $request): MessageInboxResource
    {
        $storeMessageInboxDTO = new StoreMessageInboxDTO($request->validated());

        return new MessageInboxResource($this->messageInboxService
            ->store($storeMessageInboxDTO));
    }
}
