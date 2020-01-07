<?php

namespace Fliglio\Web;

class UrlTest extends \PHPUnit_Framework_TestCase {

	private $url;

	public function testKitchenSink() {
		// given
		$this->url = Url::fromString('http://foo:bar@www.google.com:80/test/route?key=value&key2=value#foo');

		// then
		$this->assertEquals($this->url->getScheme(), 'http');
		$this->assertEquals($this->url->getQuery(), 'key=value&key2=value');
		$this->assertEquals($this->url->getHost(), 'www.google.com');
		$this->assertEquals($this->url->getPath(), '/test/route');
		$this->assertEquals($this->url->getHost(), 'www.google.com');
		$this->assertEquals($this->url->getPort(), '80');
		$this->assertEquals($this->url->getUser(), 'foo');
		$this->assertEquals($this->url->getPass(), 'bar');
		$this->assertEquals($this->url->getFragment(), 'foo');
	}

	public function testStringGeneration() {
		$data = array(
			'http://foo:bar@www.google.com:80/test/route?key=value&key2=value#foo',
			'http://foo:bar@www.google.com:80/test/route?key=value&key2=value',
			'http://www.google.com:80/test/route?key=value&key2=value',
			'http://www.google.com/test/route',
			'http://www.google.com',
			'www.google.com',
			'/test/route',
		);

		foreach ($data as $urlStr) {
			$this->assertEquals($urlStr, (string)Url::fromString($urlStr));
		}
	}

	public function testRelativeUrl() {
		$urlStr = '/foo/bar';
		$url = Url::fromString($urlStr);

		$this->assertEquals($urlStr, $url->getPath());
	}

	public function testHostAndPort() {
		$urlStr = 'foo:8080';
		$url = Url::fromString($urlStr);

		$this->assertEquals('foo', $url->getHost());
		$this->assertEquals('8080', $url->getPort());
	}

	public function testHostAndPortFactory() {
		// given
		$expectedStr = 'foo:8080';

		// when
		$found = Url::fromHostAndPort("foo", 8080);

		// then
		$this->assertEquals($expectedStr, (string)$found);
	}


}

