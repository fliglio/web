<?php

namespace Fliglio\Web;

use Fliglio\Flfc\Context;
use Fliglio\Routing\Injectable;

class ExpandGetParam implements Injectable {

	private $expandedFields = [];

	public function getClassName() {
		return __CLASS__;
	}

	/**
	 * @param Context $context
	 * @param $paramName // We don't care what the variable is named, the type tells us we want a ExpandGetParam
	 * @return ExpandGetParam
	 */
	public function create(Context $context, $paramName) {
		$getParams = $context->getRequest()->getGetParams();

		$filter = new self();

		if (isset($getParams['expand'])) {
			$split = explode(",", $getParams['expand']);
			$trimmed = array_map('trim', $split);
			$filtered = array_filter($trimmed);

			$filter->setExpandedFields($filtered);
		}

		return $filter;
	}

	/**
	 * @param $field
	 * @return bool
	 */
	public function isFieldExpanded($field) {
		return in_array($field, $this->getExpandedFields());
	}

	/**
	 * @return array
	 */
	public function getExpandedFields() {
		return $this->expandedFields;
	}

	/**
	 * @param array $expandedFields
	 * @return Fliglio\Web\ExpandGetParam
	 */
	public function setExpandedFields($expandedFields) {
		$this->expandedFields = $expandedFields;
		return $this;
	}

}