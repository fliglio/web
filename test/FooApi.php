<?php

namespace Fliglio\Web;

use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 */
class FooApi implements Validation, StaticApiMapper {
	use ObjectValidationTrait;
	use StaticApiMapperTrait;
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
	public static function getApiMapper() {
		return new FooApiMapper();
	}
}
