<?php

namespace Zhineng\NotificationChannels\AliyunSms;

use AlibabaCloud\SDK\Dysmsapi\V20170525\Dysmsapi;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\SendSmsRequest;
use AlibabaCloud\Tea\Exception\TeaUnableRetryError;
use Illuminate\Notifications\Notification;
use Zhineng\NotificationChannels\AliyunSms\Exceptions\CouldNotSendNotification;

class AliyunSmsChannel
{
    public function __construct(
        protected Dysmsapi $client
    ) {
        //
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  Notification  $notification
     * @return void
     *
     * @throws CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toAliyunSms($notifiable);

        $phoneNumber = $notifiable->routeNotificationFor('aliyun-sms', $notification);

        if (! $phoneNumber && ! $message instanceof AliyunSmsMessage) {
            return;
        }

        try {
            $this->client->sendSms(new SendSmsRequest([
                'phoneNumbers' => $phoneNumber,
                'signName' => $message->signature,
                'templateCode' => $message->templateId,
                'templateParam' => json_encode($message->payload),
                'outId' => $message->serialNumber,
            ]));
        } catch (TeaUnableRetryError $e) {
            throw CouldNotSendNotification::make($e);
        }
    }
}
