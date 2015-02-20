<?php

require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

use Fliglio\Web\Uri;

class UriTest extends PHPUnit_Framework_TestCase {

	private $refUri;

	public function setup() {
		$this->refUri = Uri::get('http://www.google.com:80/test/route?key=value&key2=value');
	}

	public function testQueryParams() {
		$this->assertEquals($this->refUri->getQuery(), 'key=value&key2=value');
	}

	public function testPath() {
		$this->assertEquals($this->refUri->getPath(), '/test/route');
	}

	public function testHost() {
		$this->assertEquals($this->refUri->getHost(), 'www.google.com');
	}
	public function testPort() {
		$this->assertEquals($this->refUri->getPort(), '80');
	}

	public function testScheme() {
		$this->assertEquals($this->refUri->getScheme(), 'http');
	}

	public function testFactory() {
		// given
		$expected = Uri::get("http://foo:8080");
		$expectedHttps = Uri::get("https://foo:8080");
		// when

		$found = Uri::fromHostAndPort("foo", 8080);
		$found2 = Uri::fromHostAndPort("foo", 8080, "http");
		$foundHttps = Uri::fromHostAndPort("foo", 8080, "https");

		// then

		$this->assertEquals($expected, $found);
		$this->assertEquals($expected, $found2);
		$this->assertEquals($expectedHttps, $foundHttps);

	}
}

