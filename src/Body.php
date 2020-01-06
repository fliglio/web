<?php

namespace Fliglio\Web;

use Fliglio\Http\Exceptions\BadRequestException;

class Body {
	private $body;

	public function __construct($body, $contentType) {
		$this->body = $body;
		$this->contentType = $contentType;
	}
	public function get() {
		return $this->body;
	}
	public function bind(ApiMapper $mapper) {
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


		$entity = $mapper->unmarshal($arr);

		if ($entity instanceof Validation) {
			try {
				$entity->validate();
			} catch (ValidationException $e) {
				throw new BadRequestException($e->getMessage());
			}
		}
		return $entity;
	}
}