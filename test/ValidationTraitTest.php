<?php
namespace Fliglio\Web;

use Fliglio\Http\Http;
use Doctrine\Common\Annotations\AnnotationRegistry;


class ValidationTraitTest extends \PHPUnit_Framework_TestCase {

	public function setUp() {
		AnnotationRegistry::registerAutoloadNamespace(
			'Symfony\\Component\\Validator\\Constraints\\', 
			dirname(__DIR__) . "/vendor/symfony/validator"
		);
	}

	/**
	 * Test that a simple model can be validated
	 */
	public function testValidation() {

		// given
		$expectedFoo = new Foo("foo");

		// when
		$expectedFoo->validate();

	}

	/**
	 * @expectedException Fliglio\Web\ValidationException
	 */
	public function testValidationError() {

		// given
		$expectedFoo = new Foo("invalid");

		// when
		$expectedFoo->validate();

	}

	/**
	 * Test that a model can be validated recursively 
	 * - when a property of the root model should also be validated
	 */
	public function testCompositeValidation() {

		// given
		$expectedBar = new Bar("foo", new Foo("foo"));
		
		// when
		$expectedBar->validate();

	}

	/**
	 * @expectedException Fliglio\Web\ValidationException
	 */
	public function testCompositeValidationError() {

		// given
		$expectedBar = new Bar("foo", new Foo("invalid"));
		
		// when
		$expectedBar->validate();

	}

	/**
	 * Test that a model can be validated recursively 
	 * - when a property of the root model is an array of 
	 *   models that should also be validated
	 */
	public function testCompositeArrayValidation() {

		// given
		$expectedBar = new Bar("foo", new Foo("foo"), array(
			new Foo("foo"),
			new Foo("foo")
		));
		
		// when
		$expectedBar->validate();

	}

	/**
	 * @expectedException Fliglio\Web\ValidationException
	 */
	public function testCompositeArrayValidationError() {

		// given
		$expectedBar = new Bar("foo", new Foo("foo"), array(
			new Foo("foo"),
			new Foo("invalid")
		));
		
		// when
		$expectedBar->validate();
	}

}
