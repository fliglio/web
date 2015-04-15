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
		$expected = new FooApi("foo");
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
		$expected = new FooApi("bar");
		$fooJson = '{"myProp": "bar"}';

		$body = new Body($fooJson, 'application/json');
		$mapper = new FooApiMapper();
		
		// when
		$found = $body->bind($mapper);
	}


}