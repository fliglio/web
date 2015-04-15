<?php

namespace Fliglio\Web;

use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 */
class Bar implements Validation {
	use ObjectValidationTrait;

    /**
     * @Assert\EqualTo(
     *     value = "foo"
     * )
     */
	private $name;

    /**
     * @Assert\Valid
     */
	private $foo; // FooApi

    /**
     * @Assert\Valid
     */
	private $foos; // []FooApi


	public function __construct($n, $f, array $fs = array()) {
		$this->name = $n;
		$this->foo = $f;
		$this->foos = $fs;
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