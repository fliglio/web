<?php

namespace Fliglio\Web;

use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 */
class FooApi implements Validation {
	use ObjectValidationTrait;

    /**
     * @Assert\EqualTo(
     *     value = "foo"
     * )
     */
	private $myProp;

	public function __construct($p) {
		$this->myProp = $p;
	}

	public function getMyProp() {
		return $this->myProp;
	}
}