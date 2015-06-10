<?php

namespace Fliglio\Web;

trait MappableApiTrait {

	public static function marshal($entity) {
		return self::getApiMapper()->marshal($this);
	}
	public static function unmarshal($valueObject) {
		return self::getApiMapper()->unmarshal($valueObject);
	}

	public static function getApiMapper() {

	
	}
}
