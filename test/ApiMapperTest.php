<?php
namespace Fliglio\Web;

use Fliglio\Http\Http;
use Doctrine\Common\Annotations\AnnotationRegistry;

class ApiMapperTest extends \PHPUnit_Framework_TestCase {

	public function testStaticApiMapper() {

		// given
		$entity = new FooApi("foo");
		$vo = ["myProp" => "foo"];

		// when
		$foundVo = $entity::marshal($entity);
		$foundEntity = FooApi::unmarshal($vo);

		// then
		$this->assertEquals($entity, $foundEntity);
		$this->assertEquals($vo, $foundVo);
	}
}
