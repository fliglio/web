<?php

namespace Fliglio\Web;

class Entity {
	private $body;
	private $contentType;

	public function __construct($body, $contentType) {
		$this->body = $body;
		$this->contentType = $contentType;
	}

	public function get() {
		return $this->body;
	}

	public function getContentType() {
		return $this->contentType;
	}

	public function bind($entityType) {
		if (!class_exists($entityType) || !in_array('Fliglio\Web\MappableApi', class_implements($entityType))) {
			throw new \Exception($entityType . " doesn't implement Fliglio\Web\MappableApi");
		}

		$arr = null;
		switch($this->contentType) {
			// consider adding multipart/form-data (for giant content or file uploads) in the future, with special handling
			case 'application/x-www-form-urlencoded':
				parse_str($this->body, $arr);
				break;
			// assume json
			case 'application/json':
			default:
				$arr = json_decode($this->body, true);
		}

		$entity = $entityType::unmarshal($arr);

		if ($entity instanceof Validation) {
			// throws ValidationException on constraint violation
			$entity->validate();
		}
		return $entity;
	}

}