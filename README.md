# Sending SMS through Alibaba Cloud in Laravel.

This package makes it easy to send notifications using [Alibaba Cloud Short Message Service](https://cn.aliyun.com/product/sms) with Laravel 9.x, and also requires PHP 8.0+.

## Contents

- [Installation](#installation)
	- [Setting up Dysms service](#setting-up-dysms-service)
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
composer require lizhineng/dysms-notification-channel
```

### Setting up Dysms service

The package includes a [configuration file](config/dysms.php). However, you are not required to export this configuration file to your own application. You can simply set the `DYSMS_KEY` and `DYSMS_SECRET` environment variables to define your Dysms API credentials which may be accessed from your [Aliyun RAM dashboard](https://ram.console.aliyun.com).

Based on the principle of least privilege, the only required RAM permission to the credentials is `dysms:SendSms`, then you're good to go. Here is an example policy in case you need it:

```json
{
    "Version": "1",
    "Statement": [
        {
            "Effect": "Allow",
            "Action": "dysms:SendSms",
            "Resource": "*"
        }
    ]
}
```

After defining your keys, you may set a `DYSMS_SIGNATURE` environment variable that defines the signature that your SMS messages should be attached to by default. You may apply your signature on [Aliyun SMS Console](https://dysms.console.aliyun.com):

```dotenv
DYSMS_SIGNATURE=YOUR_COMPANY_NAME
```

## Usage

You can now use the channel in your `via()` method inside the notification. **Note**, before you can successfully send the message out, according to the Aliyun regulation, you need to apply the template to be reviewed first.

```php
use Illuminate\Notifications\Notification;
use Zhineng\Notifications\Channels\DysmsChannel;
use Zhineng\Notifications\Messages\DysmsMessage;

class OrderPlaced extends Notification
{
    public function via($notifiable)
    {
        return ['dysms'];
    }

    public function toDysms($notifiable)
    {
        return (new DysmsMessage)
            ->using('SMS_TEMPLATE_CODE')
            ->with(['if' => 'any'])
            ->signedBy('YOUR_PERMITTED_SIGNATURE');
    }   
}
```

In order to let the channel know who's the recipient, add the method `routeNotificationForDysms` to your notifiable class.

```php
// App\Models\User.php

public function routeNotificationForDysms($notification)
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
