<?php

namespace Fliglio\Web;

class ApiMapperTest extends \PHPUnit_Framework_TestCase {
	
	public function testApiMapper() {

		// given
		$mapper = new FooApiMapper();
		
		$entity = new Foo("foo");
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
		$entity = new Foo("foo");
		$vo = ["myProp" => "foo"];

		// when
		$foundVo = $entity->marshal();
		$foundEntity = Foo::unmarshal($vo);

		// then
		$this->assertEquals($entity, $foundEntity);
		$this->assertEquals($vo, $foundVo);
	}
	public function testStaticApiMapperWithoutNamingConvention() {

		// given
		$entity = new Bar("bar", new Foo("foo"), [new Foo("baz"), new Foo("biz")]);

		// when
		$vo = $entity->marshal();
		$foundEntity = Bar::unmarshal($vo);

		// then
		$this->assertEquals($entity, $foundEntity);
	}
	
	public function testCollectionApiMapper() {

		// given
		$mapper = new CollectionApiMapper(new FooApiMapper());
		

		$entities = [new Foo("foo"), new Foo("bar")];
		$vo = [["myProp" => "foo"], ["myProp" => "bar"]];

		// when
		$foundVo = $mapper->marshal($entities);
		$foundEntities = $mapper->unmarshal($vo);

		// then
		$this->assertEquals($entities, $foundEntities);
		$this->assertEquals($vo, $foundVo);
	}

}