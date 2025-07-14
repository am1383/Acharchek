<?php

namespace App\Constants;

class RateLimitConstants
{
    public const DECAY_SECONDS = 60 * 60;

    public const MAX_ATTEMPTS_VERIFY_LOGIN = 20;

    public const MAX_ATTEMPTS_VERIFICATION = 1;
}
