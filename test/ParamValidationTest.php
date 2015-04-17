<?php
namespace Fliglio\Web;

use Fliglio\Http\Http;
use Symfony\Component\Validator\Constraints as Assert;

class ParamValidationTest extends \PHPUnit_Framework_TestCase {

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
	 * @expectedException Fliglio\Http\Exceptions\BadRequestException
	 */
	public function testBadRequestThrownWhenGettingInvalidParam() {

		// given
		$param = new Param("foo");
		$param->addConstraint(new Assert\Length(array('min' => 10)));

		// when
		$foo = $param->get();
	}


}