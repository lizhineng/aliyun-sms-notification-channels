# Aliyun SMS Notification Channel for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/aliyun-sms.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/aliyun-sms)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
![GitHub Workflow Status](https://img.shields.io/github/workflow/status/laravel-notification-channels/aliyun-sms/run-tests?style=flat-square)
[![StyleCI](https://styleci.io/repos/157489842/shield)](https://styleci.io/repos/157489842)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/:sensio_labs_id.svg?style=flat-square)](https://insight.sensiolabs.com/projects/:sensio_labs_id)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-notification-channels/aliyun-sms.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/aliyun-sms)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/laravel-notification-channels/aliyun-sms/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/aliyun-sms/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-notification-channels/aliyun-sms.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/aliyun-sms)

This package makes it easy to send notifications using [Aliyun SMS](https://cn.aliyun.com/product/sms) with Laravel 5.5+, 6.x, 7.x and 8.x, and requires PHP 7.1+

## Contents

- [Installation](#installation)
	- [Setting up the Aliyun SMS service](#setting-up-the-aliyun-sms-service)
- [Usage](#usage)
	- [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)

## Installation

You can install the package via Composer:

```bash
composer require laravel-notification-channels/aliyun-sms
```

### Setting up the Aliyun SMS service

Generate your credentials from your Aliyun console, then configure the services file...

```php
// config/services.php

...

'aliyun_sms' => [
    'key' => env('ALIYUN_SMS_ACCESS_KEY'),
    'secret' => env('ALIYUN_SMS_ACCESS_SECRET'),
],

...
```

## Usage

You can now use the channel in your `via()` method inside the notification. **Note**, before you can successfully send the message out, according to the Aliyun regulation, you need to apply the template to review first.

```php
use Illuminate\Notifications\Notification;
use NotificationChannels\AliyunSms\AliyunSmsChannel;
use NotificationChannels\AliyunSms\AliyunSmsMessage;

class OrderPlaced extends Notification
{
    public function via($notifiable)
    {
        return [AliyunSmsChannel::class]; // or 'aliyun-sms'
    }

    public function toAliyunSms($notifiable)
    {
        return (new AliyunSmsMessage)
            ->using('SMS_TEMPLATE_CODE')
            ->params(['if' => 'any'])
            ->signedBy('YOUR_SIGNATURE');
    }   
}
```

In order to let the notification know who's the recipient, add the method `routeNotificationForAliyun` to your notifiable class.

```php
public function routeNotificationForAliyunSms($notification)
{
    return $this->phone_number;
}
```

### Available message methods

* `using(string $templateCode)`: Accepts the SMS template code.
* `with(array $parameters)`: The parameters which needs to be injected into the template.
* `signedBy(string $signature)`: The name of the sender, which also needs to be reviewed first.
* `serialNumber(string $serialNumber)`: The order number, uuid, you name it.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email im@zhineng.li instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Li Zhineng](https://github.com/lizhineng)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
