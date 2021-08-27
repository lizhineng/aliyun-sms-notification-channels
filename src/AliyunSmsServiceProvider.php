<?php

namespace Zhineng\NotificationChannels\AliyunSms;

use AlibabaCloud\SDK\Dysmsapi\V20170525\Dysmsapi;
use Darabonba\OpenApi\Models\Config;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;

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
            $service->extend('aliyun-sms', function ($app) {
                $config = $app['config']->get('services.aliyun_sms');

                if (is_null($config)) {
                    throw new InvalidArgumentException('Missing Aliyun SMS API Credentials.');
                }

                $client = new Dysmsapi(new Config([
                    'accessKeyId' => $config['key'],
                    'accessKeySecret' => $config['secret'],
                    'endpoint' => 'dysmsapi.aliyuncs.com',
                ]));

                return $this->app->makeWith(AliyunSmsChannel::class, [
                    'client' => $client,
                ]);
            });
        });
    }
}
