<?php

namespace Fliglio\Web;

trait MappableApiTrait {

	public function marshal() {
		return self::getApiMapper()->marshal($this);
	}
	public static function getClass() {
		return get_called_class();
	}
	public static function unmarshal($valueObject) {
		return self::getApiMapper()->unmarshal($valueObject);
	}

	public static function getApiMapper() {
		$className = self::getClass();
		$mapperClassName = $className . 'ApiMapper';
		return new $mapperClassName();
	}
}
