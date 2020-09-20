<?php

namespace NotificationChannels\AliyunSms\Exceptions;

use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError(ClientException $e)
    {
        $description = $e->getErrorMessage();
        $code = $e->getErrorCode();

        return new static("Aliyun SMS server responded with an error [{$code}], ${description}");
    }

    public static function couldNotCommunicateWithAliyunSms(ServerException $e)
    {
        $message = $e->getErrorMessage();
        $code = $e->getErrorCode();

        return new static("Failed to communicate with Aliyun SMS server [${code}], ${message}");
    }
}
