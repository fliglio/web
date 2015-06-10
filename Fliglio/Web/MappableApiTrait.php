<?php

namespace Fliglio\Web;

trait MappableApiTrait {

	public function marshal() {
		return $this->getApiMapper()->marshal($this);
	}
	public function unmarshal($valueObject) {
		return $this->getApiMapper()->unmarshal($valueObject);
	}

	public function getApiMapper() {

	
	}
}
