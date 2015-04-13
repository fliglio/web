<?php

namespace Fliglio\Web;

class FooApi implements Validation {
	use ObjectValidationTrait;

	private $myProp;

	protected function getRules() {
		return array(
			'myProp' => 'required|minlength[2]|alpha'
		);
	}


	public function __construct($p) {
		$this->setMyProp($p);
	}

	public function getMyProp() {
		return $this->myProp;
	}
	public function setMyProp($p) {
		$this->myProp = $p;
	}
}