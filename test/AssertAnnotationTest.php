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

		// then
		$this->assertTrue(true);
	}

	/** 
	 * @dataProvider invalidDataProvider
	 * @expectedException Fliglio\Web\ValidationException 
	 */
	public function testValidationError($id, $string, $number, $stringLength, $integerMinMax) {
		// given
		$expectedAnnotation = new Annotation($id, $string, $number, $stringLength, $integerMinMax);

		// when
		$expectedAnnotation->validate();

		// then
		$this->assertTrue(false);
	}

	public function invalidDataProvider() {
		return [
			["string","string",1,substr(str_shuffle(self::CHARS), 0, 10), 1], // bad id
			[1,1,1,substr(str_shuffle(self::CHARS), 0, 10), 1], // bad string
			[1,"string","string",substr(str_shuffle(self::CHARS), 0, 10), 1], // bad number
			[1,"string",1,substr(str_shuffle(self::CHARS), 0, 25), 1], // bad string length
			[1,"string",1,substr(str_shuffle(self::CHARS), 0, 10), 1000] // bad integer max
		];
	}

}