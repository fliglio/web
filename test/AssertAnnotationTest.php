<?php
namespace Fliglio\Web;

class AssertAnnotationTest extends \PHPUnit_Framework_TestCase {
	
	const CHARS = '0123456789abcdefghijklmnopqrstuvwxyz';

	/**
	 * Test that annotations are valid
	 */
	public function testValidation() {

		// given
		$id = rand(1,9999);
		$string = substr(str_shuffle(self::CHARS), 0, 10);
		$number = rand();
		$stringLength = substr(str_shuffle(self::CHARS), 0, 10);
		$integerMinMax = rand(1,10);
		$expectedAnnotation = new Annotation($id, $string, $number, $stringLength, $integerMinMax);

		// when
		$expectedAnnotation->validate();

	}

	/**
	 * @expectedException Fliglio\Web\ValidationException
	 */
	public function testValidationError() {

		// given
		$id = "string";
		$string = 1;
		$number = "string";
		$stringLength = substr(str_shuffle(self::CHARS), 0, 20);
		$integerMinMax = 0;
		$expectedAnnotation = new Annotation($id, $string, $number, $stringLength, $integerMinMax);

		// when
		$expectedAnnotation->validate();

	}

}