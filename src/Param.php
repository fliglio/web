<?php

namespace Fliglio\Web;

use Symfony\Component\Validator\Validation as SymphonyValidation;
use Fliglio\Http\Exceptions\BadRequestException;

class Param {
	
	private $val;
	private $constraints = [];

	public function __construct($val) {
		$this->val = $val;
	}
	public function get() {
		try {
			$this->validate();
		} catch (ValidationException $e) {
			throw new BadRequestException($e->getMessage());
		}

		return $this->val;
	}

	public function addConstraint($constraint) {
		$this->constraints[] = $constraint;
		return $this;
	}

	public function validate() {
		$validator = SymphonyValidation::createValidatorBuilder()->getValidator();

		$violations = $validator->validate($this->val, $this->constraints);

		if ($violations->count() > 0) {
			throw new ValidationException($violations);
		}
	}

}