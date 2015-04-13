<?php

namespace Fliglio\Web;

class ValidationException extends \Exception {
	private $validationErrors = array();
	public function __construct($errors) {
		parent::__construct(implode((array)$errors, ", "));
		if (!is_array($errors)) {
			$errors = array($errors);
		}
		$this->validationErrors = $errors;
	}

	public function getValidationErrors() {
		return $this->validationErrors;
	}
}