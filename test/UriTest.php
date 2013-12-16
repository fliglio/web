<?php

require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

use Fliglio\Web\Uri;

class UriTest extends PHPUnit_Framework_TestCase {

	private $refUri;

	public function setup() {
		$this->refUri = Uri::get('http://www.google.com/test/route?key=value&key2=value');
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

	public function testScheme() {
		$this->assertEquals($this->refUri->getScheme(), 'http');
	}

}

