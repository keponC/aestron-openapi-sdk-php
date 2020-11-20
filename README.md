# aestron-openapi-sdk-php

Use Aestron openapi sdk client in your PHP project

## Install

```
composer require aestron/aestron-openapi-sdk
```

## Demo

```php
<?php
use AestronSdk\Sms\SmsClient;
use AestronSdk\Exception\ClientException;

SmsClient::setAppId('z3i0plp74s22rj');
SmsClient::setCertificate('yRC3vrpUFgpSpw');
try {
    $res = SmsClient::send([
        'to' => '8615826666666',
        'content' => 'Do not go gentle into that good night.',
        'from' => 'BIGO',
        'type' => 'OTP',
        'session' => '168201771',
    ]);
    var_export($res);
} catch (\Exception $e) {
    var_export($e->getMessage());
    var_export(SmsClient::getLastRequestParam());
}
```

