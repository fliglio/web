# fliglio-web

2. Simplified interface to PHP's curl functions
Example:
```php
use Fliglio\Web\Curl;
use Fliglio\Web\CurlRequest;
use Fliglio\Web\CurlResponse;

$curl = new Curl();
$response = $curl->request(new CurlRequest(Curl::GET, 'http://www.google.com'));

print($response->getContent());
```
See test/CurlTest.php for working examples

2. Encapsulated REST calls using Curl
Example:
```php
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

2. Tests
Run tests using:
```bash
phpunit test
```