<?php

namespace NotificationChannels\AliyunSms;

use AlibabaCloud\Client\AlibabaCloud;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class AliyunSmsServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Notification::resolved(function (ChannelManager $service) {
            if ($config = config('services.aliyun_sms')) {
                AlibabaCloud::accessKeyClient($config['key'], $config['secret'])
                    ->regionId($config['region'])
                    ->name('aliyun-sms');
            }

            $service->extend('aliyun-sms', function ($app) {
                return $this->app->make(AliyunSmsChannel::class);
            });
        });
    }
}
