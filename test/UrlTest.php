<?php
namespace Fliglio\Web;

class UrlTest extends \PHPUnit_Framework_TestCase {

	private $url;

	public function setup() {
	}

	public function testKitchenSink() {
		// given
		$this->url = Url::fromString('http://foo:bar@www.google.com:80/test/route?key=value&key2=value');

		// then
		$this->assertEquals($this->url->getScheme(), 'http');
		$this->assertEquals($this->url->getQuery(), 'key=value&key2=value');
		$this->assertEquals($this->url->getHost(), 'www.google.com');
		$this->assertEquals($this->url->getPath(), '/test/route');
		$this->assertEquals($this->url->getHost(), 'www.google.com');
		$this->assertEquals($this->url->getPort(), '80');
		$this->assertEquals($this->url->getScheme(), 'http');
	}

	public function testFactory() {
		// given
		$expectedStr = 'foo:8080';

		// when
		$found = Url::fromHostAndPort("foo", 8080);

		// then
		$this->assertEquals($expectedStr, (string)$found);

	}
}

