<?php

namespace Fliglio\Web;

use Fliglio\Web\Validation;
use Fliglio\Web\MappableApi;
use Symfony\Component\Validator\Constraints as Assert;

class Bar implements Validation, MappableApi {
	use ObjectValidationTrait;
	use MappableApiTrait;

	/**
	 * @Assert\EqualTo(
	 *     value = "foo"
	 * )
	 */
	private $name;

	/**
	 * @Assert\EqualTo(
	 *     value = "bar"
	 * )
	 */
	private $otherName;

	/**
	 * @Assert\Valid
	 */
	private $foo; // Foo

	/**
	 * @Assert\Valid
	 */
	private $foos; // []Foo

	public function __construct($n, $f, array $fs = []) {
		$this->name = $n;
		$this->foo  = $f;
		$this->foos = $fs;
	}
	
	public static function getApiMapper() {
		return new BarApiMapper();
	}

	public function getName() {
		return $this->name;
	}

	public function getFoo() {
		return $this->foo;
	}

	public function getFoos() {
		return $this->foos;
	}

	/**
	 * @return mixed
	 */
	public function getOtherName() {
		return $this->otherName;
	}

	/**
	 * @param mixed $otherName
	 * @return Bar
	 */
	public function setOtherName($otherName) {
		$this->otherName = $otherName;
		return $this;
	}


}
