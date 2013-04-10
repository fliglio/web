<?php

namespace Fliglio\Web;

/**
 * Wrap url strings with this to expose & encapsulate common url needs
 * 
 */
class Uri {
	
	/* String version of the url */
	protected $url;
	
	/**
	 * Create a new Url
	 * 
	 * @param String / Web_Uri the url to use 
	 */
	public function __construct($url) {
		$this->setUri($url);
	}
	
	public static function get($str) { 
		return new self($str); 
	}
	
	/**
	 * Get url as a string
	 * 
	 * @return String url as a string
	 */
	public function getUri() { 
		return $this->url;
	}

	/**
	 * Set current url value
	 * 
	 * @param String / Web_Uri  new url value
	 * @return Url  this instance for chaining commands
	 */
	public function setUri($val) { 
		$this->url = (string) $val;
		return $this;
	}

	/**
	 * Append relative url to current url
	 * 
	 * @param String / Web_Uri  relative url to append
	 * @return Url  this instance for chaining commands
	 */
	public function join($extra) {
		$newUrl = sprintf( 
			"%s/%s", 
			rtrim($this->getUri(), '/'), 
			ltrim((string) $extra, '/')
		);
		return $this->setUri($newUrl);
	}
	
	/**
	 * Get new url with current instance as base and parameter appended
	 * 
	 * @param String / Url  relative url to append
	 * @return Url  new instance with urls combined
	 */
	public function combine($extra) {
		$inst = clone $this;
		return $inst->join($extra);
	}

	/**
	 * Add supplied parameters to supplied url & return result.
	 * 
	 * Url might already have parameters.
	 * Params will overwrite base url if there is overlap.
	 * 
	 * @param  Web_Uri url  base url to add params to
	 * @param  String[]    associative array of parameters
	 * @return Url      merged url
	 */
	public static function merge(Uri $url, array $params = array()) {
	
		$parsedUrl   = parse_url($url);
		
		$parts       = explode("?", $url);
		$base        = array_shift($parts);

		$query       = array();
		$queryString = isset($parsedUrl['query']) ? $parsedUrl['query'] : '';
		parse_str($queryString, $query);

		$query = array_merge($query, $params);
	
		return new self(sprintf( 
			"%s%s%s",
			$base,
			!empty($query) ? '?' : '',
			http_build_query($query)
		));
	}
	
	/**
	 * Get string version of the url
	 * 
	 * @return String  string representation of this instance; the url
	 */
	public function __tostring() {
		return $this->getUri();
	}

}

