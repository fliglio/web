<?php
namespace Fliglio\Web;

use Fliglio\Http\Http;
use Symfony\Component\Validator\Constraints as Assert;

class ParamValidationTest extends \PHPUnit_Framework_TestCase {

	//=========================================================================
	// Param
	//

	public function testParamShouldValidateWithNoConstraints() {
		// given
		$param = new Param("foo");
		
		// when
		$param->validate();
		
		// then
		$this->assertEquals("foo", $param->get());
	}

	/**
	 * @expectedException Fliglio\Web\ValidationException
	 */
	public function testBadRequestThrownWhenValidatingInvalidParam() {
		// given
		$param = new Param("foo");
		$param->addConstraint(new Assert\Length(array('min' => 10)));

		// when
		$param->validate();
	}

	/**
	 * @expectedException Fliglio\Http\Exceptions\UnprocessableEntityException
	 */
	public function testBadRequestThrownWhenGettingInvalidParam() {

		// given
		$param = new Param("foo");
		$param->addConstraint(new Assert\Length(array('min' => 10)));

		// when
		$foo = $param->get();
	}

	//=========================================================================
	// IntParam
	//

	public function testIntParamShouldValidateIntegerValue() {
		// given
		$param = new IntParam(123);
		
		// when
		$param->validate();
		
		// then
		$this->assertEquals(123, $param->get());
	}

	/**
	 * @expectedException Fliglio\Web\ValidationException
	 */
	public function testBadRequestThrownWhenValidatingInvalidIntParam() {
		// given
		$param = new IntParam("foo");

		// when
		$param->validate();
	}

	/**
	 * @expectedException Fliglio\Http\Exceptions\UnprocessableEntityException
	 */
	public function testBadRequestThrownWhenGettingInvalidIntParam() {

		// given
		$param = new IntParam("foo");

		// when
		$foo = $param->get();
	}

	//=========================================================================
	// IntGetParam
	//

	public function testIntGetParamShouldValidateIntegerValue() {
		// given
		$param = new IntGetParam(123);
		
		// when
		$param->validate();
		
		// then
		$this->assertEquals(123, $param->get());
	}

	/**
	 * @expectedException Fliglio\Web\ValidationException
	 */
	public function testBadRequestThrownWhenValidatingInvalidIntGetParam() {
		// given
		$param = new IntGetParam("foo");

		// when
		$param->validate();
	}

	/**
	 * @expectedException Fliglio\Http\Exceptions\UnprocessableEntityException
	 */
	public function testBadRequestThrownWhenGettingInvalidIntGetParam() {

		// given
		$param = new IntGetParam("foo");

		// when
		$foo = $param->get();
	}

	//=========================================================================
	// IntPathParam
	//

	public function testIntPathParamShouldValidateIntegerValue() {
		// given
		$param = new IntPathParam(123);
		
		// when
		$param->validate();
		
		// then
		$this->assertEquals(123, $param->get());
	}

	/**
	 * @expectedException Fliglio\Web\ValidationException
	 */
	public function testBadRequestThrownWhenValidatingInvalidIntPathParam() {
		// given
		$param = new IntPathParam("foo");

		// when
		$param->validate();
	}

	/**
	 * @expectedException Fliglio\Http\Exceptions\UnprocessableEntityException
	 */
	public function testBadRequestThrownWhenGettingInvalidIntPathParam() {

		// given
		$param = new IntPathParam("foo");

		// when
		$foo = $param->get();
	}

}