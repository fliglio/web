<?php

namespace Fliglio\Web;

use Fliglio\Http\Exceptions\UnprocessableEntityException;
use Fliglio\Http\Exceptions\BadRequestException;

class Entity {
	private $body;

	public function __construct($body, $contentType) {
		$this->body = $body;
		$this->contentType = $contentType;
	}
	public function get() {
		return $this->body;
	}
	public function bind($entityType) {
		if (!in_array('Fliglio\Web\MappableApi', class_implements($entityType))) {
			throw new BadRequestException($entityType . " doesn't implement Fliglio\Web\MappableApi");
		}

		$arr = null;
		switch($this->contentType) {
			// assume json
			case 'application/json':
			default:
				$arr = json_decode($this->body, true);
		}

		$entity = $entityType::unmarshal($arr);

		if ($entity instanceof Validation) {
			try {
				$entity->validate();
			} catch (ValidationException $e) {
				throw new UnprocessableEntityException($e->getMessage());
			}
		}
		return $entity;
	}
}
