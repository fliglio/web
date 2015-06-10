<?php

namespace Fliglio\Web;

class FooApiMapper implements ApiMapper {

	public function marshal($foo) {
		return array(
			'myProp' => $foo->getMyProp()
		);
	}

	public function unmarshal($fooArr) {
		return new Foo($fooArr['myProp']);
	}
}
