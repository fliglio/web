<?php

namespace Fliglio\Web;

class MediaType {

	const JSON = 'json';
	const XML  = 'xml';

	// Type specific headers
	private static $accept = array(
		self::JSON => "Accept: application/json; charset=utf-8",
		self::XML  => "Accept: application/xml;q=0.9",
	);

	private static $content = array(
		self::JSON => "Content-Type: application/json; charset=utf-8",
		self::XML  => "Content-Type: application/xml;q=0.9",
	);

	public static function getAccept($type) {
		if (!isset(self::$accept[$type])) {
			
		}
		return self::$accept[$type];
	}

	public static function getContent($type) {
		if (!isset(self::$content[$type])) {
			
		}
		return self::$content[$type];
	}

}