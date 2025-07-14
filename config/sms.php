<?php

return [

   /*
    |--------------------------------------------------------------------------
    | Phone verification code length
    |--------------------------------------------------------------------------
    |
    | Show cost for every group of users in toman (In every 65 characters)
    |
    */

    'phone_verification_code_length' => 5,

    /*
    |--------------------------------------------------------------------------
    | SMS Cost
    |--------------------------------------------------------------------------
    |
    | Show cost for every group of users in toman (In every 65 characters)
    |
    */
    'sms_cost' => [
        'service' => 300,
        'remember' => 300,
        'single' => 100,
        'group' => 100,
        'extra' => 100,
    ],
];
