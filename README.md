# Sending SMS through Alibaba Cloud in Laravel.

This package makes it easy to send notifications using [Alibaba Cloud Short Message Service](https://cn.aliyun.com/product/sms) with Laravel 9.x, and also requires PHP 8.0+.

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
composer require lizhineng/notification-channel-aliyun-sms
```

### Setting up the Aliyun SMS service

Generate your API credentials from your Aliyun console, then configure the services file...

```php
// config/services.php

...

'aliyun_sms' => [
    'key' => env('ALIYUN_SMS_ACCESS_KEY_ID', env('ALIYUN_ACCESS_KEY_ID')),
    'secret' => env('ALIYUN_SMS_ACCESS_KEY_SECRET', env('ALIYUN_ACCESS_KEY_SECRET')),
],

...
```

## Usage

You can now use the channel in your `via()` method inside the notification. **Note**, before you can successfully send the message out, according to the Aliyun regulation, you need to apply the template to be reviewed first.

```php
use Illuminate\Notifications\Notification;
use Zhineng\NotificationChannels\AliyunSms\AliyunSmsChannel;
use Zhineng\NotificationChannels\AliyunSms\AliyunSmsMessage;

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
            ->with(['if' => 'any'])
            ->signedBy('YOUR_PERMITTED_SIGNATURE');
    }   
}
```

In order to let the channel know who's the recipient, add the method `routeNotificationForAliyunSms` to your notifiable class.

```php
// App\Models\User.php

public function routeNotificationForAliyunSms($notification)
{
    return $this->phone_number;
}
```

### Available message methods

* `using(string $templateCode)`: Accepts the SMS template code.
* `with(array $payload)`: The parameters which needs to be injected into the template.
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
