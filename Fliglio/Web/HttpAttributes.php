<?php

namespace Fliglio\Web;

/**
 * Attributes of a http request
 *
 */
class HttpAttributes {
	
	const HTTPS = 'https';
	const HTTP  = 'http';

	const METHOD_POST = 'post';
	const METHOD_GET = 'get';
	const METHOD_PUT = 'put';
	const METHOD_DELETE = 'delete';
	const METHOD_OPTIONS = 'options';

	private static $protocol;
	private static $httpHost;
	private static $method;
	
	public static function apacheDefaults() {
		// Configure Web Package
		$isHttps = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on';

		HttpAttributes::setProtocol($isHttps ? HttpAttributes::HTTPS : HttpAttributes::HTTP);

		HttpAttributes::setHttpHost(
			isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : (
				isset($_SERVER['HOSTNAME']) ? $_SERVER['HOSTNAME'] : (
					isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : (
						isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : (
							'localhost'
						)
					)
				)
			)
		);

		switch (isset($_SERVER['REQUEST_METHOD']) ? strtolower($_SERVER['REQUEST_METHOD']) : null) {
			case 'post' : 
				HttpAttributes::setMethod(HttpAttributes::METHOD_POST);
				break;
			case 'get' : 
				HttpAttributes::setMethod(HttpAttributes::METHOD_GET);
				break;
			case 'put' : 
				HttpAttributes::setMethod(HttpAttributes::METHOD_PUT);
				break;
			case 'delete' : 
				HttpAttributes::setMethod(HttpAttributes::METHOD_DELETE);
				break;
			case 'options' : 
				HttpAttributes::setMethod(HttpAttributes::METHOD_OPTIONS);
				break;
		}
	}
	
	/**
	 * Override the detected value for current request protocol
	 */
	public static function setProtocol($protocol) {
		self::$protocol = $protocol;
	}

	/**
	 * Override the detected value for current httpHost
	 */
	public static function setHttpHost($httpHost) {
		self::$httpHost = $httpHost;
	}

	/**
	 * Gets protocol of current request (http or https)
	 *
	 * Gets protocol from built in HTTPS constant, or special
	 * ROI_HTTPS_REQUEST constant set on port 81 traffic that was ssl
	 * but was decrypted by the load balancer
	 * 
	 * @return string  constant representing http or https's value
	 */
	public static function getProtocol() {
		return self::$protocol;
	}

	/**
	 * finds and returns http host of current request
	 *
	 * @return string  web host name
	 */
	public static function getHttpHost() {
		return self::$httpHost;
	}

	public static function getMethod() {
		return self::$method;
	}
	public static function setMethod($method) {
		self::$method = $method;
	}

}