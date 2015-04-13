<?php
namespace Fliglio\Web;

use Fliglio\Http\Http;

class BodyTest extends \PHPUnit_Framework_TestCase {

	public function testBindMapping() {

		// given
		$expected = new FooApi("hello");
		$fooJson = '{"myProp": "hello"}';

		$body = new Body($fooJson, 'application/json');
		$mapper = new FooApiMapper();
		
		// when
		$found = $body->bind($mapper);

		// then
		$this->assertEquals($expected, $found);
	}

	/**
	 * @expectedException Fliglio\Http\Exceptions\BadRequestException
	 */
	public function testBindValidationError() {

		// given
		$expected = new FooApi("spaces are invalid");
		$fooJson = '{"myProp": "spaces are invalid"}';

		$body = new Body($fooJson, 'application/json');
		$mapper = new FooApiMapper();
		
		// when
		$found = $body->bind($mapper);
	}


}