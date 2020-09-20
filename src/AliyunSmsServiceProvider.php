<?php

namespace NotificationChannels\AliyunSms;

use AlibabaCloud\Client\AlibabaCloud;
use Illuminate\Support\ServiceProvider;

class AliyunSmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($config = config('services.aliyun_sms')) {
            AlibabaCloud::accessKeyClient($config['key'], $config['secret'])
                ->name('aliyun-sms');
        }
    }
}
