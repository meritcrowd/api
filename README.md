## MeritCrowd API Documentation

### PHP
```php
<?php

include('MeritCrowdApi.php');

$api = new MeritCrowdApi(
	"3845772082",
	"58bae4986d8db3b16713c81b386462564583b4efb71be24a7dddf4ac535fdb3c",
	"http://dev.boostcontent.com/api/"
);

$orders = $api->getOrders();
$tasks = $api->getTasks(350);

$api->addTask(350, array(
	'keywords' => 'Keyword1, Keyword2',
	'anchorText' => 'Anchor Text',
	'anchorUrl' => 'http://example.com',
	'_myCustomId' => 42
));

?>
```

### Python
```python
from MeritCrowdApi import *

api = MeritCrowdApi(
	"3845772082",
	"58bae4986d8db3b16713c81b386462564583b4efb71be24a7dddf4ac535fdb3c",
	"http://dev.boostcontent.com/api/"
)

orders = api.getOrders()
tasks = api.getTasks(350)

api.addTask(350, {
	'keywords': 'Keyword1, Keyword2',
	'anchorText': 'Anchor Text',
	'anchorUrl': 'http://example.com',
	'_myCustomId': 42
})
```

### Ruby
```ruby
require 'MeritCrowdApi'

api = MeritCrowdApi.new(
	"3845772082",
	"58bae4986d8db3b16713c81b386462564583b4efb71be24a7dddf4ac535fdb3c",
	"http://dev.boostcontent.com/api/"
)

orders = api.getOrders()
tasks = api.getTasks(350)

api.addTask(350, {
	'keywords' => 'Keyword1, Keyword2',
	'anchorText' => 'Anchor Text',
	'anchorUrl' => 'http://example.com',
	'_myCustomId' => 42
})
```

