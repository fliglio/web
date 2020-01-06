<?php

namespace Fliglio\Web;

class CollectionApiMapper implements ApiMapper {
	
	private $mapper;

	public function __construct(ApiMapper $mapper) {
		$this->mapper = $mapper;
	}
	
	public function marshal($entities) {
		$vos = [];

		foreach ($entities as $key => $entity) {
			$vos[$key] = $this->mapper->marshal($entity);
		}
		return $vos;
	}
	public function unmarshal($serialized) {
		$entities = [];

		foreach ($serialized as $key => $vo) {
			$entities[$key] = $this->mapper->unmarshal($vo);
		}
		return $entities;
	}
}
