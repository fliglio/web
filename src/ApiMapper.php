<?php

namespace Fliglio\Web;

interface ApiMapper {
	public function marshal($entity);
	public function unmarshal($serialized);
}