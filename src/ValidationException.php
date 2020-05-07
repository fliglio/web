<?php

namespace Fliglio\Web;

use Fliglio\Http\Exceptions\BadRequestException;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

class ValidationException extends BadRequestException {
	/** @var ConstraintViolationListInterface */
	private $constraintViolationList;
	public function __construct(ConstraintViolationListInterface $constraintViolationList) {
		parent::__construct($constraintViolationList);
		$this->constraintViolationList = $constraintViolationList;
	}

	/**
	 * @return ConstraintViolationListInterface
	 */
	public function getConstraintViolationList() {
		return $this->constraintViolationList;
	}
}