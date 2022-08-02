<?php

namespace Zhineng\Notifications\Facades;

use AlibabaCloud\SDK\Dysmsapi\V20170525\Dysmsapi;
use Illuminate\Support\Facades\Facade;

class Dysms extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return Dysmsapi::class;
    }
}
