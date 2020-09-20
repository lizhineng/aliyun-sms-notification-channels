<?php

namespace NotificationChannels\AliyunSms\Test;

use NotificationChannels\AliyunSms\AliyunSmsMessage;
use PHPUnit\Framework\TestCase;

class AliyunSmsMessageTest extends TestCase
{
    /** @var AliyunSmsMessage */
    protected $message;

    public function setUp(): void
    {
        parent::setUp();

        $this->message = (new AliyunSmsMessage)
            ->using('SMS_1234')
            ->with(['foo' => 'bar'])
            ->signedBy('baz')
            ->serialNumber('PO-001');
    }

    public function testHasTemplateCode()
    {
        $this->assertEquals('SMS_1234', $this->message->templateId);
    }

    public function testHasTemplateParameters()
    {
        $this->assertEquals(['foo' => 'bar'], $this->message->params);
    }

    public function testHasSignature()
    {
        $this->assertEquals('baz', $this->message->signature);
    }

    public function testHasSerialNumber()
    {
        $this->assertEquals('PO-001', $this->message->serialNumber);
    }
}
