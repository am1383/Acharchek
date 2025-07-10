<?php

return [
    'max_user_own_businesses' => 5,
    'max_user_join_businesses' => 15,

    'phone_verification_code_length' => 5,  // min:3  max:6  به هیچ عنوان نباید طول کد از 3 کمتر و از 3 بیشتر باشد

    'max_business_customer_groups' => 15, // بیشتر از ۱۵ گروه نمیتوانید ثبت کنید!

    'business_new_customers_per_hour' => 30, // هر کسب و کار 30 تا مشتری میتونه در ساعت ثبت کنه!

    'sms_cost' => [
        'service' => 300, // toman
        'remember' => 300, // toman
        'single' => 100, // toman به ازای هر 65 کاراکتر
        'group' => 100, // toman به ازای هر 65 کاراکتر
        'extra' => 100, // مبلغ اضافی برای افزودن آدرس و ایدی اینستاگرام به پیامک های سرویس و یادآوری
    ],
];
