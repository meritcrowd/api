## MeritCrowd API Documentation

### PHP
```php
<?php

include('MeritCrowdApi.php');

$api = new MeritCrowdApi(
	"3845772082",
	"48bae4986d8db3b16713c81b386462564583b4efb71be24a7dddf4ac535fdb3c",
	"https://www.boostcontent.com/api/"
);

$jobs = $api->getJobs();
$tasks = $api->getTasks(350);

$api->addTask(350, array(
	'Keywords' => 'Keyword1, Keyword2',
	'Link Text' => 'Anchor Text',
	'Link URL' => 'http://example.com',
	'_myCustomId' => 42
));

?>
```

### Python
```python
from MeritCrowdApi import *

api = MeritCrowdApi(
	"3845772082",
	"48bae4986d8db3b16713c81b386462564583b4efb71be24a7dddf4ac535fdb3c",
	"https://www.boostcontent.com/api/"
)

jobs = api.getJobs()
tasks = api.getTasks(350)

api.addTask(350, {
	'Keywords': 'Keyword1, Keyword2',
	'Link Text': 'Anchor Text',
	'Link URL': 'http://example.com',
	'_myCustomId': 42
})
```

### Ruby
```ruby
require 'MeritCrowdApi'

api = MeritCrowdApi.new(
	"3845772082",
	"48bae4986d8db3b16713c81b386462564583b4efb71be24a7dddf4ac535fdb3c",
	"https://www.boostcontent.com/api/"
)

jobs = api.getJobs()
tasks = api.getTasks(350)

api.addTask(350, {
	'Keywords' => 'Keyword1, Keyword2',
	'Link Text' => 'Anchor Text',
	'Link URL' => 'http://example.com',
	'_myCustomId' => 42
})
```

