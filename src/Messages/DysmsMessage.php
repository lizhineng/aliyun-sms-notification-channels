<?php

namespace Zhineng\Notifications\Messages;

class DysmsMessage
{
    /**
     * The message template code.
     *
     * @var string
     */
    public string $templateCode;

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
     * Set template code for the message.
     *
     * @param  string  $templateCode
     * @return $this
     */
    public function using(string $templateCode)
    {
        $this->templateCode = $templateCode;

        return $this;
    }

    /**
     * Set payload for the message.
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
     * Set signature for the message.
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
