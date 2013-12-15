<?php

namespace Fliglio\Web;

class CurlFactory {

	private static $driver = null;

	/**
	 * @return CurlInterface
	 */
	public static function get() {
		// Default driver, Curl
		if (is_null(self::$driver)) {
			$driver = new Curl();
			return $driver;
		}

		return self::$driver;
	}

	public static function setDriver(CurlInterface $driver) {
		self::$driver = $driver;
	}

}