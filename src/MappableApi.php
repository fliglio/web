<?php

namespace Fliglio\Web;

interface MappableApi {
	public function marshal();
	public static function unmarshal($serialized);
}