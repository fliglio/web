<?php
namespace Fliglio\Web\Client;

use Fliglio\Http\Http;

class ClientTest extends \PHPUnit_Framework_TestCase {

	public function testSuccess() {
		$client = new BasicClient();
		$b = new BasicRequestBuilder();
		$req = $b
			->method(Http::METHOD_GET)
			->url('https://postman-echo.com/get')
			->build();

		$resp = $client->makeRequest($req);
		$this->assertEquals(HTTP::STATUS_OK, $resp->getStatus());
	}

	public function testError() {
		$client = new BasicClient();
		$b = new BasicRequestBuilder();
		$req = $b
			->method(Http::METHOD_PUT)
			->url('http://www.google.com')
			->build();

		$resp = $client->makeRequest($req);

		$this->assertEquals(HTTP::STATUS_METHOD_NOT_ALLOWED, $resp->getStatus());
	}

	public function testGet() {
		$client = new BasicClient();
		$resp = $client->get('https://postman-echo.com/get', []);

		$this->assertEquals(HTTP::STATUS_OK, $resp->getStatus());
	}

	public function testGet_withBody() {
		$client = new BasicClient();
		$resp = $client->get('https://postman-echo.com/get', []);
		$body = json_decode($resp->getBody(), true);
		$headers = $resp->getHeaders();

		$this->assertEquals(HTTP::STATUS_OK, $resp->getStatus());
		$this->assertEquals('https://postman-echo.com/get', $body['url']);
		$this->assertEquals('HTTP/1.1 200 OK', $headers[0]);
	}

	public function testGetWithHeaders() {
		$headers = ['Authorization: gfhjui'];
		$client = new BasicClient();
		$resp = $client->get('http://www.google.com', $headers);

		$this->assertEquals(HTTP::STATUS_OK, $resp->getStatus());
	}

	public function testPut() {
		$client = new BasicClient();
		$resp = $client->put('https://postman-echo.com/put');

		$this->assertEquals(HTTP::STATUS_OK, $resp->getStatus());
	}

	public function testPost() {
		$client = new BasicClient();
		$resp = $client->post('https://postman-echo.com/post');

		$this->assertEquals(HTTP::STATUS_OK, $resp->getStatus());
	}

	public function testDelete() {
		$client = new BasicClient();
		$resp = $client->delete('https://postman-echo.com/delete');

		$this->assertEquals(HTTP::STATUS_OK, $resp->getStatus());
	}

}

