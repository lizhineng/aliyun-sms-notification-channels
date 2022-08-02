<?php

namespace Zhineng\NotificationChannels\AliyunSms;

class AliyunSmsMessage
{
    /**
     * The message template code.
     *
     * @var string
     */
    public string $templateId;

    /**
     * The parameters of the message.
     *
     * @var array
     */
    public array $payload = [];

    /**
     * The signature for the message.
     *
     * @var string|null
     */
    public ?string $signature = null;

    /**
     * The serial number you can mark the message.
     *
     * @var string|null
     */
    public ?string $serialNumber = null;

    /**
     * Set the SMS template code.
     *
     * @param  string  $templateId
     * @return $this
     */
    public function using(string $templateId)
    {
        $this->templateId = $templateId;

        return $this;
    }

    /**
     * Set the payload for the message.
     *
     * @param  array  $payload
     * @return $this
     */
    public function with(array $payload)
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * Set the message signature.
     *
     * @param  string  $signature
     * @return $this
     */
    public function signedBy(string $signature)
    {
        $this->signature = $signature;

        return $this;
    }

    /**
     * The serial number you can mark the message.
     *
     * @param  string  $serialNumber
     * @return $this
     */
    public function serialNumber(string $serialNumber)
    {
        $this->serialNumber = $serialNumber;

        return $this;
    }
}
