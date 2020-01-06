<?php

namespace Fliglio\Web;

use Fliglio\Web\Validation;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 */
class Annotation implements Validation {
	use ObjectValidationTrait;
	
	/**
	 * @Assert\Type(type="integer")
	 * @Assert\GreaterThan(value="0")
	 */
	private $id;

	/**
	 * @Assert\Type(type="string")
	 * @Assert\NotBlank()
	 */
	private $string;

	/**
	 * @Assert\Type(type="numeric")
	 * @Assert\NotBlank()
	 */
	private $number;

	/**
	 * @Assert\Length(max = 10)
	 */
	private $stringLength;

	/**
	 * @Assert\Type("integer")
	 * @Assert\Range(min=0,max=10)
	 */
	private $integerMinMax;


	public function __construct($id, $string, $number, $stringLength, $integerMinMax) {
		$this->id = $id;
		$this->string = $string;
		$this->number = $number;
		$this->stringLength = $stringLength;
		$this->integerMinMax = $integerMinMax;
	}

	public function getId() {
		return $this->id;
	}
	public function getString() {
		return $this->string;
	}
	public function getNumber() {
		return $this->number;
	}
	public function getStringLength() {
		return $this->stringLength;
	}
	public function getIntegerMinMax() {
		return $this->integerMinMax;
	}
}
