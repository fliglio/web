<?php

namespace Fliglio\Web;

interface StaticApiMapper {
	public static function marshal($entity);
	public static function unmarshal($serialized);
}
