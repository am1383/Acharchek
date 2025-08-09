<?php

namespace App\Constants;

class MessageCode
{
    public const ERROR_SMS_100 = 'error.sms.100';

    public const ERROR_VALIDATION_100 = 'error.validation.100';

    public const ERROR_VALIDATION_101 = 'error.validation.101';

    public const ERROR_VALIDATION_102 = 'error.validation.102';

    public const ERROR_VALIDATION_103 = 'error.validation.103';

    public const ERROR_PHONE_VERIFICATION_RATE_LIMIT_100 = 'error.phone_verification.rate_limit.100';

    public const ERROR_PHONE_VERIFICATION_100 = 'error.phone_verification.100';

    public const ERROR_PHONE_VERIFICATION_101 = 'error.phone_verification.101';

    public const ERROR_PHONE_VERIFICATION_102 = 'error.phone_verification.102';

    public const ERROR_RATE_LIMITER_100 = 'error.rate_limiter.100';

    public const ERROR_USER_REGISTRATION_100 = 'error.user_registration.100';

    public const ERROR_VERIFICATION_EXPIRATION_9 = '9';

    public const ERROR_DATABASE_10 = '10';

    public const ERROR_VERIFICATION_CODE_11 = '11';

    public const ERROR_BUSINESS_100 = 'error.business.100';

    public const ERROR_BUSINESS_101 = 'error.business.101';

    public const ERROR_BUSINESS_102 = 'error.business.102';

    public const ERROR_BUSINESS_103 = 'error.business.103';

    public const ERROR_BUSINESS_104 = 'error.business.104';

    public const ERROR_BUSINESS_105 = 'error.business.105';

    public const ERROR_BUSINESS_106 = 'error.business.106';

    public const ERROR_CUSTOMER_100 = 'error.customer.100';

    public const ERROR_SMS_CREDIT_100 = 'error.sms_credit.100';

    public const ERROR_USER_100 = 'error.user.100';

    public static function messageText(?string $code): string
    {
        $messages = [
            self::ERROR_SMS_100 => 'مشکلی در هنگام ارسال کد تایید به شماره موبایل شما پیش آمد. لطفا دوباره تلاش کنید. اگر که این مشکل حل نشد لطفا با پشتیبانی تماس بگیرید!',

            self::ERROR_VALIDATION_100 => 'عنوان عملیات نامعتبر است!',
            self::ERROR_VALIDATION_101 => 'اطلاعات ورودی نامعتبر هستند!',
            self::ERROR_VALIDATION_102 => 'این ایمیل قبلا روی حساب کاربری دیگری ثبت شده است. لطفا یک ایمیل متفاوت وارد کنید!',
            self::ERROR_VALIDATION_103 => 'این شماره موبایل قبلا روی یک حساب کاربری دیگر تنظیم شده است. لطفا یک شماره موبایل متفاوت وارد کنید و یا نسبت به ورود با این شماره موبایل اقدام کنید.',

            self::ERROR_PHONE_VERIFICATION_100 => 'بین ارسال هر کد تایید باید حدود 2 دقیقه صبر کنید!',
            self::ERROR_PHONE_VERIFICATION_101 => 'مهلت استفاده از کد تایید تمام شده است. لطفا جهت ارسال کد تایید جدید اقدام کنید!',
            self::ERROR_PHONE_VERIFICATION_102 => 'کد تایید وارد شده صحیح نیست. لطفا در وارد کردن کد تایید دقت کنید!',
            self::ERROR_PHONE_VERIFICATION_RATE_LIMIT_100 => 'لطفا جهت ارسال کد تایید جدید %s ثانیه صبر کنید!',

            self::ERROR_RATE_LIMITER_100 => 'تعداد دفعات تلاش شما بیش از حد مجاز بوده است. لطفا پس از %s دوباره تلاش کنید!',

            self::ERROR_USER_REGISTRATION_100 => 'جلسه ثبت نام یافت نشد!',

            self::ERROR_VERIFICATION_EXPIRATION_9 => 'کد تایید منقضی شده است',

            self::ERROR_DATABASE_10 => 'مشکلی در هنگام ثبت اطلاعات پیش آمد. لطفا دوباره تلاش کنید!',

            self::ERROR_VERIFICATION_CODE_11 => 'کد تایید اشتباه است',

            self::ERROR_BUSINESS_100 => 'شما هنوز هیچ کسب و کاری ثبت نکرده اید لطفا ابتدا کسب و کار خود را ثبت و مشخص کنید!',
            self::ERROR_BUSINESS_101 => 'مشتری با این شماره موبایل قبلا در کسب و کار ثبت شده است!',
            self::ERROR_BUSINESS_102 => 'این کسب و کار قبلا به عنوان کسب و کار فعال حساب شما تنظیم شده است!',
            self::ERROR_BUSINESS_103 => 'کسب و کار مشخص شده در لیست کسب و کار های شما یافت نشد!',
            self::ERROR_BUSINESS_104 => 'بیشتر از این تعداد نمیتوانید کسب و کار ثبت کنید!',
            self::ERROR_BUSINESS_105 => 'شما دسترسی به این بخش از کسب و کار ندارید!',
            self::ERROR_BUSINESS_106 => 'کسب و کار یافت نشد! این یک مشکل جدی در ساختار سیستم است! لطفا با پشتیبانی تماس بگیرید!',

            self::ERROR_CUSTOMER_100 => 'شناسه مشتری نامعتبر است و مشتری یافت نشد!',

            self::ERROR_SMS_CREDIT_100 => 'اعتبار پیامکی شما برای ارسال این پیامک کافی نیست!',

            self::ERROR_USER_100 => 'حساب کاربری کاربر (شما) مسدود شده است. لطفا با پشتیبانی تماس بگیرید!',
        ];

        return $messages[$code];
    }
}
