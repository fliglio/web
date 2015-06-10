<?php

namespace Fliglio\Web;

use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 */
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
     * @Assert\Valid
     */
	private $foo; // Foo

    /**
     * @Assert\Valid
     */
	private $foos; // []Foo


	public function __construct($n, $f, array $fs = array()) {
		$this->name = $n;
		$this->foo = $f;
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
}
