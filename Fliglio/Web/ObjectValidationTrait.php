<?php

namespace Fliglio\Web;

use werx\Validation\Engine;


trait ObjectValidationTrait {
	
	public function validate() {
		$input = array();
		$rules = $this->getRules();
		$validator = new Engine();

		foreach ($rules as $fieldName => $fieldRules) {
			// use reflection
			$value = $this->{$fieldName};

			$input[$fieldName] = $value;

			$validator->addRule($fieldName, $fieldName, $fieldRules);
		}

		if (!$validator->validate($input)) {
			throw new ValidationException($validator->getErrorSummary());
		}
	}


	protected function getRules() {
		return array();
	}
}