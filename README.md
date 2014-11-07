== MeritCrowd API Documentation
===
==== Examples
```php
include('MeritCrowdApi.php');

$api = new MeritCrowdApi("{API_KEY}", "{API_SECRET}", "{API_ENDPOINT}");

$orders = $api->getOrders();
$tasks = $api->getTasks(123);

$api->addTask(123, array(
    'keywords' => 'Keyword1, Keyword2',
    'anchorText' => 'Anchor Text',
    'anchorUrl' => 'http://example.com',
    '_myCustomId' => 42
));
```
