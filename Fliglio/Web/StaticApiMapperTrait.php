<?php

namespace Fliglio\Web;

trait StaticApiMapperTrait {

	public static function marshal($entity) {
		return self::getApiMapper()->marshal($entity);
	}
	public static function unmarshal($valueObject) {
		return self::getApiMapper()->unmarshal($valueObject);
	}

	public static function getApiMapper() {

	
	}
}
