<?php

namespace App\Constants;

class Constants
{
    public const ERROR_RATE_LIMITER_100 = 'تعداد دفعات تلاش شما بیش از حد مجاز بوده است. لطفا پس از %s دوباره تلاش کنید!';

    public const ERROR_PHONE_VERIFICATION_RATE_LIMIT_100 = 'لطفا جهت ارسال کد تایید جدید %s ثانیه صبر کنید!';

    public const PREFIX_VERIFY_LOGIN = 'rl_verify_login_';

    public const PREFIX_VERIFY_CODE = 'rl_verify_code_';

    public const PREFIX_PHONE_VERIFICATION = 'phone_verification_';

    public const PREFIX_VERIFY_REGISTER = 'rl_register_user_';
}
