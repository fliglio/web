<?php

require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

use Fliglio\Web\Curl;
use Fliglio\Web\CurlRequest;
use Fliglio\Web\CurlResponse;

class CurlTest extends PHPUnit_Framework_TestCase {

	public function testSuccess() {
		$curl = new Curl();
		$resp = $curl->request(new CurlRequest(Curl::GET, 'http://www.google.com'));

		$this->assertEquals($resp->getHttpCode(), 200);
	}

	public function testError() {
		$curl = new Curl();
		$resp = $curl->request(new CurlRequest(Curl::PUT, 'http://www.google.com'));

		$this->assertEquals($resp->getHttpCode(), 405); // method not allowed
	}

}

