<?php

namespace Fliglio\Web;

use Fliglio\Flfc\Context;
use Fliglio\Flfc\Request;
use Fliglio\Flfc\Response;

class ExpandGetParamTest extends \PHPUnit_Framework_TestCase {

	public function testGetClassName() {
		// given
		$expected  = "Fliglio\Web\ExpandGetParam";
		$param     = new ExpandGetParam();

		// when
		$className = $param->getClassName();

		// then
		$this->assertEquals($expected, $className);
	}

	public function testCreate() {
		// given
		$request = new Request();
		$request->setGetParams(["expand"=>"one,two"]);
		
		$context = new Context($request, new Response());
		$param   = new ExpandGetParam();

		// when
		$return = $param->create($context, "");

		// then
		$expandableFields = $return->getExpandedFields();
		$this->assertCount(2, $expandableFields);
		$this->assertEquals("one", $expandableFields[0]);
		$this->assertEquals("two", $expandableFields[1]);
	}

	public function testIsFieldExpandable() {
		// given
		$request = new Request();
		$request->setGetParams(["expand"=>"one"]);
		
		$context = new Context($request, new Response());
		$param   = new ExpandGetParam();

		// when
		$return = $param->create($context, "");

		// then
		$this->assertTrue($return->isFieldExpanded("one"));
		$this->assertFalse($return->isFieldExpanded("two"));
	}

}