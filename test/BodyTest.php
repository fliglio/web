<?php

namespace Fliglio\Web;

use Fliglio\Http\Exceptions\BadRequestException;

class BodyTest extends \PHPUnit_Framework_TestCase {

	public function testGet() {
		// given
		$fooJson = '{"myProp": "foo"}';
		$body = new Body($fooJson, 'application/json');
		
		// when
		$getBody = $body->get();

		// then
		$this->assertEquals($fooJson, $getBody);
	}

	public function testBindMapping() {
		// given
		$expected = new Foo("foo");
		$fooJson = '{"myProp": "foo"}';

		$body = new Body($fooJson, 'application/json');
		$mapper = new FooApiMapper();

		// when
		$found = $body->bind($mapper);

		// then
		$this->assertEquals($expected, $found);
	}

	public function testBodyMappingOfPOSTFormData() {
		// given
		$expected = new Foo("foo");
		$query = 'myProp=foo&foo=bar';

		$body = new Body($query, 'application/x-www-form-urlencoded');
		$mapper = new FooApiMapper();

		// when
		$found = $body->bind($mapper);

		// then
		$this->assertEquals($expected, $found);
	}

	public function testBindValidationError() {
		// given
		$fooJson = '{"myProp": "bar"}';

		$body = new Body($fooJson, 'application/json');
		$mapper = new FooApiMapper();

		// then
		$this->expectException(BadRequestException::class);

		// when
		$body->bind($mapper);
	}

	
}
