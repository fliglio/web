<?php

$loader = require __DIR__.'/../vendor/autoload.php';

error_reporting(E_ALL | E_STRICT);
ini_set("display_errors" , 1);

use Doctrine\Common\Annotations\AnnotationRegistry;

AnnotationRegistry::registerLoader([$loader, 'loadClass']);