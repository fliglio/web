<?php

namespace Fliglio\Web;

trait MappableApiTrait {

	public function marshal() {
		return self::getApiMapper()->marshal($this);
	}
	public static function unmarshal($valueObject) {
		return self::getApiMapper()->unmarshal($valueObject);
	}
	public static function marshalCollection(array $entities) {
		$vos = [];
		foreach ($entities as $entity) {
			$vos[] = $entity->marshal();
		}
		return $vos;
	}
	public static function unmarshalCollection($vos) {
		$entities = [];
		foreach ($vos as $vo) {
			$entities[] = self::unmarshal($vo);
		}
		return $entities;
	}

	public static function getClass() {
		return get_called_class();
	}
	public static function getApiMapper() {
		$className = self::getClass();
		$mapperClassName = $className . 'ApiMapper';
		return new $mapperClassName();
	}
}
