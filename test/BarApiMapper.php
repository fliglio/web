<?php

namespace Fliglio\Web;

class BarApiMapper implements ApiMapper {

	public function marshal($bar) {
		$fooMapper = $bar->getFoo()->getApiMapper();
		return [
			'name' => $bar->getName(),
			'foo'  => $fooMapper->marshal($bar->getFoo()),
			'foos' => (new CollectionApiMapper($fooMapper))->marshal($bar->getFoos()),
		];
	}

	public function unmarshal($fooArr) {
		$fooMapper = new FooApiMapper();
		return new Bar(
			$fooArr['name'],
			$fooMapper->unmarshal($fooArr['foo']),
			(new CollectionApiMapper($fooMapper))->unmarshal($fooArr['foos'])
		);
	}
}
