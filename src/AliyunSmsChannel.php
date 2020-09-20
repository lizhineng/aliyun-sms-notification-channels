<?php

namespace NotificationChannels\AliyunSms;

use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Request\RpcRequest;
use NotificationChannels\AliyunSms\Exceptions\CouldNotSendNotification;
use Illuminate\Notifications\Notification;

class AliyunSmsChannel
{
    /**
     * The client of Aliyun SMS.
     *
     * @var RpcRequest
     */
    protected $aliyun;

    /**
     * Channel constructor.
     *
     * @param  RpcRequest  $aliyun
     */
    public function __construct(RpcRequest $aliyun)
    {
        $this->aliyun = $aliyun;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @throws \NotificationChannels\AliyunSms\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        if (!$to = $notifiable->routeNotificationFor('aliyun-sms', $notification)) {
            return;
        }

        $message = $notification->toAliyunSms($notifiable);

        try {
            $this->request($to, $message);
        } catch (ClientException $e) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($e);
        } catch (ServerException $e) {
            throw CouldNotSendNotification::couldNotCommunicateWithAliyunSms($e);
        }
    }

    /**
     * Fire the request to the API endpoint.
     *
     * @param  string  $to
     * @param  AliyunSmsMessage  $message
     * @return \AlibabaCloud\Client\Result\Result
     * @throws ClientException
     * @throws ServerException
     */
    protected function request(string $to, AliyunSmsMessage $message)
    {
        return $this->aliyun
            ->client('aliyun-sms')
            ->product('Dysmsapi')
            ->version('2017-05-25')
            ->action('SendSms')
            ->method('POST')
            ->host('dysmsapi.aliyuncs.com')
            ->options([
                'query' => [
                    'RegionId' => 'cn-hangzhou',
                    'PhoneNumbers' => $to,
                    'SignName' => $message->signature,
                    'TemplateCode' => $message->templateId,
                    'TemplateParam' => json_encode($message->params),
                    'OutId' => $message->serialNumber ?? null,
                ],
            ])
            ->request();
    }
}
