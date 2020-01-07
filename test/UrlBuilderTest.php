<?php
namespace Fliglio\Web;

class UrlBuilderTest extends \PHPUnit_Framework_TestCase {

	public function testConstruct() {
		// given
		$url = Url::fromString('https://postman-echo.com/get?foo1=bar1&foo2=bar2');
		
		// when
		$builtUrl = (new UrlBuilder($url))->build();

		// then
		$this->assertEquals($builtUrl->getScheme(),   $url->getScheme());
		$this->assertEquals($builtUrl->getQuery(),    $url->getQuery());
		$this->assertEquals($builtUrl->getHost(),     $url->getHost());
		$this->assertEquals($builtUrl->getPath(),     $url->getPath());
		$this->assertEquals($builtUrl->getHost(),     $url->getHost());
		$this->assertEquals($builtUrl->getPort(),     $url->getPort());
		$this->assertEquals($builtUrl->getUser(),     $url->getUser());
		$this->assertEquals($builtUrl->getPass(),     $url->getPass());
		$this->assertEquals($builtUrl->getFragment(), $url->getFragment());
	}

}