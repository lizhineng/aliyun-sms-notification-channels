<?php

namespace Zhineng\NotificationChannels\AliyunSms\Test;

use PHPUnit\Framework\TestCase;
use Zhineng\NotificationChannels\AliyunSms\AliyunSmsMessage;

class AliyunSmsMessageTest extends TestCase
{
    protected AliyunSmsMessage $message;

    public function setUp(): void
    {
        parent::setUp();

        $this->message = (new AliyunSmsMessage)
            ->using('SMS_1234')
            ->with(['foo' => 'bar'])
            ->signedBy('baz')
            ->serialNumber('uuid');
    }

    public function test_has_template_id()
    {
        $this->assertEquals('SMS_1234', $this->message->templateId);
    }

    public function test_has_payload()
    {
        $this->assertEquals(['foo' => 'bar'], $this->message->payload);
    }

    public function test_has_signature()
    {
        $this->assertEquals('baz', $this->message->signature);
    }

    public function test_has_serial_number()
    {
        $this->assertEquals('uuid', $this->message->serialNumber);
    }
}
