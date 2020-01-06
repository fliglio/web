<?php
namespace Fliglio\Web;

use Doctrine\Common\Annotations\AnnotationRegistry;

class IntParamTest extends \PHPUnit_Framework_TestCase {

	public function setUp() {
		AnnotationRegistry::registerAutoloadNamespace(
			'Symfony\\Component\\Validator\\Constraints\\', 
			dirname(__DIR__) . "/vendor/symfony/validator"
		);
	}

	public function testValid_IntegerString() {
		$param = new IntParam('34');
		$param->validate();

		$this->assertTrue(true);
	}

	public function testValid_IntegerStringIsInt() {
		$param = new IntParam('34');
		$param->validate();
		

		$this->assertTrue(is_int($param->get()));
	}
	/**
	 * @expectedException Fliglio\Web\ValidationException
	 */
	public function testInvalid_IntegerString() {
		$param = new IntParam('34.34');
		$param->validate();
	}

	/**
	 * @expectedException Fliglio\Web\ValidationException
	 */
	public function testInvalid_IntegerAlphaString() {
		$param = new IntParam('34a');
		$param->validate();
	}

	public function testValid_Integer() {
		$param = new IntParam(34);
		$param->validate();

		$this->assertTrue(true);
	}

	/**
	 * @expectedException Fliglio\Web\ValidationException
	 */
	public function testInvalid_Double() {
		$param = new IntParam(34.34);
		$param->validate();
	}

}
