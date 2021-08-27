<?php

namespace Zhineng\NotificationChannels\AliyunSms\Test;

use AlibabaCloud\SDK\Dysmsapi\V20170525\Dysmsapi;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\SendSmsRequest;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use PHPUnit\Framework\TestCase;
use Zhineng\NotificationChannels\AliyunSms\AliyunSmsChannel;
use Zhineng\NotificationChannels\AliyunSms\AliyunSmsMessage;

class AliyunSmsChannelTest extends TestCase
{
    public function test_sends_notification()
    {
        $notifiable = new TestNotifiable;

        $client = $this->getMockBuilder(Dysmsapi::class)->disableOriginalConstructor()->getMock();
        $channel = new AliyunSmsChannel($client);

        $client->expects($this->once())
            ->method('sendSms')
            ->with(new SendSmsRequest([
                'phoneNumbers' => '11111111111',
                'signName' => 'baz',
                'templateCode' => 'SMS_1234',
                'templateParam' => json_encode(['foo' => 'bar']),
                'outId' => 'unique-serial-id',
            ]));

        $channel->send($notifiable, new TestNotification);

        $this->markAsSuccess();
    }

    protected function markAsSuccess()
    {
        $this->assertTrue(true);
    }
}

class TestNotifiable
{
    use Notifiable;

    public function routeNotificationForAliyunSms()
    {
        return '11111111111';
    }
}

class TestNotification extends Notification
{
    public function toAliyunSms($notifiable): AliyunSmsMessage
    {
        return (new AliyunSmsMessage)
            ->using('SMS_1234')
            ->with(['foo' => 'bar'])
            ->signedBy('baz')
            ->serialNumber('unique-serial-id');
    }
}
