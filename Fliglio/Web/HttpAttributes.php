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

	private static $protocol;
	private static $httpHost;
	private static $method;

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