<?php

namespace Fliglio\Web;

class ValidationTraitTest extends \PHPUnit_Framework_TestCase {

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

	public function testValidationExceptionContent() {

		// given
		$validationErrorMessageName = 'This value should be equal to "foo".';
		$validationErrorMessageOtherName = 'This value should be equal to "bar".';

		$expectedBar = (new Bar("invalid", null))->setOtherName("invalid");

		// when
		try {
			$expectedBar->validate();
			$this->fail("expected exception, shouldn't be here");
		} catch (ValidationException $e) {
			$this->assertContains($validationErrorMessageName, $e->getMessage());
			$this->assertContains($validationErrorMessageOtherName, $e->getMessage());
			$this->assertEquals($validationErrorMessageName, $e->getConstraintViolationList()->get(0)->getMessage());
			$this->assertEquals($validationErrorMessageOtherName, $e->getConstraintViolationList()->get(1)->getMessage());
		}
	}

}