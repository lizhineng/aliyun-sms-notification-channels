<?php

namespace NotificationChannels\AliyunSms;

class AliyunSmsMessage
{
    /**
     * The message template id.
     *
     * @var string
     */
    public $templateId;

    /**
     * The parameters of the message.
     *
     * @var array
     */
    public $params = [];

    /**
     * The signature of the message.
     *
     * @var string
     */
    public $signature;

    /**
     * The serial number you can mark the message.
     *
     * @var string|null
     */
    public $serialNumber;

    /**
     * Set the SMS template id.
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
     * Set the params for the message.
     *
     * @param  array  $params
     * @return $this
     */
    public function with(array $params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * The signature of the message.
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
    public function serialNumber($serialNumber)
    {
        $this->serialNumber = $serialNumber;

        return $this;
    }
}
