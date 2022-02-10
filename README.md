```
composer require raph6/telegram-bot
```


```php
$telegram = new TelegramBot('00000000000:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
$telegram->getChannelsId();
$telegram->sendMessage('YOUR_CHANNEL_ID', 'your message');
```