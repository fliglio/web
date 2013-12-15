# fliglio-web

Simplified interface to PHP's curl functions
--------------------------------------------
Example:
```php
<?php

use Fliglio\Web\Curl;
use Fliglio\Web\CurlRequest;
use Fliglio\Web\CurlResponse;

$curl = new Curl();
$response = $curl->request(new CurlRequest(Curl::GET, 'http://www.google.com'));

print($response->getContent());
```

See test/CurlTest.php for working examples

Concise REST calls
--------------------------------------------
Example:
```php
<?php

use Fliglio\Web\RestResource;
use Fliglio\Web\MediaType;

$resource = new RestResource::build('localhost:8080', true);
	->accept(MediaType::JSON)
	->addHeader('Authorization: LKJSDF21AIU87LK213ADFS;')
	->path('/api/user')
	->path(1);

$response = $resource->get();

print($response->getContent());
```

See test/RestTest.php for working examples

Unit Tests
----------
Run tests using:

	phpunit test
