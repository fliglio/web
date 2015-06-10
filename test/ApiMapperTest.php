<?php
namespace Fliglio\Web;

use Fliglio\Http\Http;
use Doctrine\Common\Annotations\AnnotationRegistry;

class ApiMapperTest extends \PHPUnit_Framework_TestCase {
	
	public function testApiMapper() {

		// given
		$mapper = new FooApiMapper();
		
		$entity = new FooApi("foo");
		$vo = ["myProp" => "foo"];

		// when
		$foundVo = $mapper->marshal($entity);
		$foundEntity = $mapper->unmarshal($vo);

		// then
		$this->assertEquals($entity, $foundEntity);
		$this->assertEquals($vo, $foundVo);
	}

	public function testStaticApiMapper() {

		// given
		$entity = new FooApi("foo");
		$vo = ["myProp" => "foo"];

		// when
		$foundVo = $entity->marshal();
		$foundEntity = FooApi::unmarshal($vo);

		// then
		$this->assertEquals($entity, $foundEntity);
		$this->assertEquals($vo, $foundVo);
	}
}
