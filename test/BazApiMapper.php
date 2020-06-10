<?php

namespace Fliglio\Web;

class BazApiMapper implements ApiMapper {

	public function marshal($baz) {
		return array(
			'myProp' => $baz->getMyProp()
		);
	}

	public function unmarshal($bazArr) {
		return new Baz($bazArr['myProp']);
	}

}