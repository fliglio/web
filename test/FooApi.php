<?php

namespace Fliglio\Web;

use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 */
class FooApi implements Validation, MappableApi {
	use ObjectValidationTrait;
	use MappableApiTrait;
    /**
     * @Assert\EqualTo(
     *     value = "foo"
     * )
     */
	private $myProp;

	public function __construct($p=null) {
		$this->myProp = $p;
	}

	public function getMyProp() {
		return $this->myProp;
	}
	public function getApiMapper() {
		return new FooApiMapper();
	}
}
