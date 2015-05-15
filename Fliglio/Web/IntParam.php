<?php

namespace Fliglio\Web;

use Symfony\Component\Validator\Constraints as Assert;

class IntParam extends Param {
	public function __construct($val) {
		parent::__construct($val);

		$this->addConstraint(new Assert\Regex([
            'pattern' => '/^[-+]?\d+$/',
            'message' => 'The value {{ value }} is not a valid integer.'
        ]));
	}
}