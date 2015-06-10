<?php

namespace Fliglio\Web;

interface MappableApi {
	public function marshal();
	public function unmarshal($serialized);
}
