<?php

namespace Zhineng\NotificationChannels\AliyunSms\Exceptions;

use AlibabaCloud\Tea\Exception\TeaUnableRetryError;
use Exception;

class CouldNotSendNotification extends Exception
{
    public static function make(TeaUnableRetryError $e)
    {
        $code = $e->getCode();
        $description = $e->getMessage();

        return new static("Aliyun SMS server responded with an error [{$code}], ${description}");
    }
}
