<?php
namespace Fliglio\Web\Client;

use Fliglio\Http\Http;

class ClientTest extends \PHPUnit_Framework_TestCase {

	public function testSuccess() {
		$client = new BasicClient();
		$b = new BasicRequestBuilder();
		$req = $b
			->method(Http::METHOD_GET)
			->url('http://www.google.com')
			->build();

		$resp = $client->makeRequest($req);

		$this->assertEquals($resp->getStatus(), 200);
	}

	public function testError() {
		$client = new BasicClient();
		$b = new BasicRequestBuilder();
		$req = $b
			->method(Http::METHOD_PUT)
			->url('http://www.google.com')
			->build();

		$resp = $client->makeRequest($req);

		$this->assertEquals($resp->getStatus(), 405); // method not allowed
	}

}

