<?php

namespace Fliglio\Web;


class Baz implements MappableApi {
	use MappableApiTrait;

	private $myProp;

	public function __construct($p=null) {
		$this->myProp = $p;
	}

	public function getMyProp() {
		return $this->myProp;
	}

}