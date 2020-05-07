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


	public function testEntityMapping() {
		// given
		$expected = new Foo("foo");
		$fooJson = '{"myProp": "foo"}';

		$body = new Entity($fooJson, 'application/json');

		// when
		$found = $body->bind('Fliglio\Web\Foo');

		// then
		$this->assertEquals($expected, $found);
	}

	public function testEntityMappingOfPOSTFormData() {
		// given
		$expected = new Foo("foo");
		$query = 'myProp=foo&foo=bar';

		$body = new Entity($query, 'application/x-www-form-urlencoded');

		// when
		$found = $body->bind('Fliglio\Web\Foo');

		// then
		$this->assertEquals($expected, $found);
	}

	public function testEntityBadApiClass() {
		// given
		$fooJson = '{"myProp": "bar"}';

		$body = new Entity($fooJson, 'application/json');

		// then
		$this->expectException(\Exception::class);

		// when
		$body->bind('Fliglio\Web\Foodfsdfsdf'); // not a real class
	}

	public function testEntityBadApiInterface() {
		// given
		$fooJson = '{"myProp": "bar"}';

		$body = new Entity($fooJson, 'application/json');

		// then
		$this->expectException(\Exception::class);

		// when
		$body->bind('Fliglio\Web\FooMapper'); // valid class, wrong interface
	}

	public function testEntityValidationError() {
		// given
		$fooJson = '{"myProp": "bar"}';

		$body = new Entity($fooJson, 'application/json');

		// then
		$this->expectException(BadRequestException::class);

		// when
		$body->bind('Fliglio\Web\Foo');
	}

	public function testEntityValidationErrorConstraintAccess() {
		// given
		$validationErrorMessageName = 'This value should be equal to "foo".';

		$fooJson = '{"myProp": "bar"}';

		$body = new Entity($fooJson, 'application/json');

		// when
		try {
			$body->bind('Fliglio\Web\Foo');
			$this->fail("expected exception, shouldn't be here");
		} catch (ValidationException $e) {
			$this->assertContains($validationErrorMessageName, $e->getMessage());
			$this->assertEquals($validationErrorMessageName, $e->getConstraintViolationList()->get(0)->getMessage());

		}
	}

	public function testEntityCopying() {
		// given
		$expected = new Foo("foo");
		$fooJson = '{"myProp": "foo"}';

		$oldBody = new Entity($fooJson, 'application/json');

		// when
		$body = new Entity($oldBody->get(), $oldBody->getContentType());
		$found = $body->bind('Fliglio\Web\Foo');

		// then
		$this->assertEquals($expected, $found);
	}
	
}
