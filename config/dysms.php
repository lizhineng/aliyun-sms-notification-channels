<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Message Signature
    |--------------------------------------------------------------------------
    |
    | This configuration option define the global signature which will be
    | attached to every single message. You should provide the signature
    | you have already applied in your Alibaba Cloud dashboard.
    |
    */

    'signature' => env('DYSMS_SIGNATURE'),

    /*
    |--------------------------------------------------------------------------
    | API Credentials
    |--------------------------------------------------------------------------
    |
    | The following configuration options contain your API credentials, which
    | may be accessed from your Alibaba Cloud RAM dashboard. `dysms:SendSms`
    | is the only permission we need for the credentials to send messages.
    |
    */

    'accessKeyId' => env('DYSMS_KEY'),

    'accessKeySecret' => env('DYSMS_SECRET'),

    'endpoint' => env('DYSMS_ENDPOINT', 'dysmsapi.aliyuncs.com'),

];
