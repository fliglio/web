<?php

namespace Fliglio\Web;

/**
 * Wrap url strings with this to expose & encapsulate common url needs
 *
 */
class Uri {

	/* String version of the url */
	protected $url;

	/* Array of url parts */
	protected $parts;

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

	public function getPath() {
		return isset($this->parts['path'])?$this->parts['path']:'';
	}

	public function getScheme() {
		return isset($this->parts['scheme'])?$this->parts['scheme']:'';
	}

	public function getQuery() {
		return isset($this->parts['query'])?$this->parts['query']:'';
	}

	public function getHost() {
		return isset($this->parts['host'])?$this->parts['host']:'';
	}
	public function getPort() {
		return isset($this->parts['port'])?$this->parts['port']:'';
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
		$this->url   = (string) $val;
		$this->parts = parse_url($this->url);

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
		$inst = clone$this;
		return $inst->join($extra);
	}

	public function addParams(array $params) {
		$parsedUrl = parse_url((string) $this);

		$parts = explode("?", (string) $this);
		$base  = array_shift($parts);

		$query       = array();
		$queryString = isset($parsedUrl['query'])?$parsedUrl['query']:'';
		parse_str($queryString, $query);

		$query = array_merge($query, $params);

		$this->setUri(sprintf(
				"%s%s%s",
				$base,
				!empty($query)?'?':'',
				http_build_query($query)
			));
		return $this;
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
		$url = clone$url;
		$url->addParams($params);
		return $url;
	}

	public static function fromHostAndPort($host, $port, $scheme = "http") {
		return new self(sprintf("%s://%s:%s", $scheme, $host, $port));
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
