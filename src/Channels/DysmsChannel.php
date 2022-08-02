<?php

namespace Zhineng\Notifications\Channels;

use AlibabaCloud\SDK\Dysmsapi\V20170525\Dysmsapi;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\SendSmsRequest;
use AlibabaCloud\Tea\Exception\TeaUnableRetryError;
use Illuminate\Notifications\Notification;
use Zhineng\Notifications\Exceptions\CouldNotSendNotification;

class DysmsChannel
{
    public function __construct(
        protected Dysmsapi $client,
        protected ?string $signature = null
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
     * @throws \Zhineng\Notifications\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('dysms', $notification)) {
            return;
        }

        $message = $notification->toDysms($notifiable);

        try {
            $this->client->sendSms(new SendSmsRequest([
                'phoneNumbers' => $to,
                'signName' => $message->signature ?: $this->signature,
                'templateCode' => $message->templateCode,
                'templateParam' => json_encode($message->payload),
                'outId' => $message->serialNumber,
            ]));
        } catch (TeaUnableRetryError $e) {
            throw CouldNotSendNotification::make($e);
        }
    }
}
