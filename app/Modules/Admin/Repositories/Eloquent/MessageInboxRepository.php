<?php

namespace App\Modules\Admin\Repositories\Eloquent;

use App\Core\Repositories\BaseRepository;
use App\Modules\Admin\Repositories\Contracts\MessageInboxRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class MessageInboxRepository extends BaseRepository implements MessageInboxRepositoryInterface
{
    public function __construct(protected Model $model) {}
}
