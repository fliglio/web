<?php
namespace Fliglio\Web;

use Fliglio\Http\Http;
use Doctrine\Common\Annotations\AnnotationRegistry;

class BodyTest extends \PHPUnit_Framework_TestCase {

	public function setUp() {
		AnnotationRegistry::registerAutoloadNamespace(
			'Symfony\\Component\\Validator\\Constraints\\',
			dirname(__DIR__) . "/vendor/symfony/validator"
		);
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

	/**
	 * @expectedException Fliglio\Http\Exceptions\BadRequestException
	 */
	public function testBindValidationError() {

		// given
		$expected = new Foo("bar");
		$fooJson = '{"myProp": "bar"}';

		$body = new Body($fooJson, 'application/json');
		$mapper = new FooApiMapper();

		// when
		$found = $body->bind($mapper);
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

	/**
	 * @expectedException \Exception
	 */
	public function testEntityBadApiClass() {

		// given
		$expected = new Foo("bar");
		$fooJson = '{"myProp": "bar"}';

		$body = new Entity($fooJson, 'application/json');

		// when
		$found = $body->bind('Fliglio\Web\Foodfsdfsdf'); // not a real class
	}

	/**
	 * @expectedException \Exception
	 */
	public function testEntityBadApiInterface() {

		// given
		$expected = new Foo("bar");
		$fooJson = '{"myProp": "bar"}';

		$body = new Entity($fooJson, 'application/json');

		// when
		$found = $body->bind('Fliglio\Web\FooMapper'); // valid class, wrong interface
	}

	/**
	 * @expectedException Fliglio\Http\Exceptions\BadRequestException
	 */
	public function testEntityValidationError() {

		// given
		$expected = new Foo("bar");
		$fooJson = '{"myProp": "bar"}';

		$body = new Entity($fooJson, 'application/json');

		// when
		$found = $body->bind('Fliglio\Web\Foo');
	}

	public function testEntityCopying() {

		// given
		$expected = new Foo("foo");
		$fooJson = '{"myProp": "foo"}';

		$oldBody = new Entity($fooJson, 'application/json');
		$body = new Entity($oldBody->get(), $oldBody->getContentType());

		// when
		$found = $body->bind('Fliglio\Web\Foo');

		// then
		$this->assertEquals($expected, $found);
	}
}
