<?php

namespace Fliglio\Web;

use Symfony\Component\Validator\Validation as SymphonyValidation;


trait ObjectValidationTrait {
	
	public function validate() {

		$validator = SymphonyValidation::createValidatorBuilder()
		    ->enableAnnotationMapping()
		    ->getValidator();

		$violations = $validator->validate($this);

		if ($violations->count() > 0) {
			throw new ValidationException($violations);
		}
	}

}