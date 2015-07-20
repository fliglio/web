<?php

namespace Fliglio\Web;

use Symfony\Component\Validator\Validation as SymphonyValidation;
use Fliglio\Http\Exceptions\UnprocessableEntityException;

class Param {
	private $val;
	private $constraints = array();

	public function __construct($val) {
		$this->val = $val;
	}
	public function get() {
		try {
			$this->validate();
		} catch (ValidationException $e) {
			throw new UnprocessableEntityException($e->getMessage());
		}

		return $this->val;
	}

	public function addConstraint($constraint) {
		$this->constraints[] = $constraint;
		return $this;
	}

	public function validate() {
		$validator = SymphonyValidation::createValidator();

		$violations = $validator->validateValue($this->val, $this->constraints);

		if ($violations->count() > 0) {
			throw new ValidationException($violations);
		}
	}

}