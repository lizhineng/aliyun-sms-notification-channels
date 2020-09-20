<?php

namespace NotificationChannels\AliyunSms\Test;

use AlibabaCloud\Client\Request\RpcRequest;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Mockery;
use NotificationChannels\AliyunSms\AliyunSmsChannel;
use NotificationChannels\AliyunSms\AliyunSmsMessage;
use PHPUnit\Framework\TestCase;

class AliyunSmsChannelTest extends TestCase
{
    public function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }

    public function testItCanSendMessage()
    {
        $notifiable = new TestNotifiable;

        $channel = new AliyunSmsChannel(
            $aliyun = Mockery::mock(RpcRequest::class)
        );

        $aliyun->expects('client')->with('aliyun-sms')->andReturnSelf();
        $aliyun->expects('product')->with('Dysmsapi')->andReturnSelf();
        $aliyun->expects('version')->with('2017-05-25')->andReturnSelf();
        $aliyun->expects('action')->with('SendSms')->andReturnSelf();
        $aliyun->expects('method')->with('POST')->andReturnSelf();
        $aliyun->expects('host')->with('dysmsapi.aliyuncs.com')->andReturnSelf();
        $aliyun->expects('options')->with([
            'query' => [
                'RegionId' => 'cn-hangzhou',
                'PhoneNumbers' => '11111111111',
                'SignName' => 'baz',
                'TemplateCode' => 'SMS_1234',
                'TemplateParam' => json_encode(['foo' => 'bar']),
                'OutId' => null,
            ],
        ])->andReturnSelf();
        $aliyun->expects('request')->once();

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
    public function toAliyunSms()
    {
        return (new AliyunSmsMessage)
            ->using('SMS_1234')
            ->with(['foo' => 'bar'])
            ->signedBy('baz');
    }
}
