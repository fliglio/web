<?php

namespace Fliglio\Web;

class Url {

	private $scheme   = null;
	private $host     = null;
	private $port     = null;
	private $user     = null;
	private $pass     = null;
	private $path     = null;
	private $query    = null;
	private $fragment = null;

	public function __construct($scheme = null, $host = null, $port = null, $user = null, $pass = null, $path = null, $query = null, $fragment = null) {
		$this->scheme   = $scheme;
		$this->host     = $host;
		$this->port     = $port;
		$this->user     = $user;
		$this->pass     = $pass;
		$this->path     = $path;
		$this->query    = $query;
		$this->fragment = $fragment;
	}

	public function getScheme() {
		return $this->scheme;
	}

	public function getHost() {
		return $this->host;
	}

	public function getPort() {
		return $this->port;
	}

	public function getUser() {
		return $this->user;
	}

	public function getPass() {
		return $this->pass;
	}

	public function getPath() {
		return $this->path;
	}

	public function getQuery() {
		return $this->query;
	}
	
	public function getFragment() {
		return $this->fragment;
	}

	public static function fromHostAndPort($host, $port) {
		return new Url(null, $host, $port);
	}

	public static function fromString($urlStr) {
		$p = parse_url($urlStr);
		return self::fromParts($p);
	}

	public static function fromParts(array $parts) {
		$inst = new self();
		foreach ($parts	as $key => $val) {
			$inst->$key = $val;
		}
		return $inst;
	}

	public function toParts() {
		return array(
			'scheme' => $this->scheme,
			'host' => $this->host,
			'port' => $this->port,
			'user' => $this->user,
			'pass' => $this->pass,
			'path' => $this->path,
			'query' => $this->query,
			'fragment' => $this->fragment
		);
	}

	public function __tostring() {
		$parse_url = $this->toParts();
			return 
				 ((isset($parse_url['scheme'])) ? $parse_url['scheme'] . '://' : '')
				.((isset($parse_url['user'])) ? $parse_url['user'] . ((isset($parse_url['pass'])) ? ':' . $parse_url['pass'] : '') .'@' : '')
				.((isset($parse_url['host'])) ? $parse_url['host'] : '')
				.((isset($parse_url['port'])) ? ':' . $parse_url['port'] : '')
				.((isset($parse_url['path'])) ? $parse_url['path'] : '')
				.((isset($parse_url['query'])) ? '?' . $parse_url['query'] : '')
				.((isset($parse_url['fragment'])) ? '#' . $parse_url['fragment'] : '')
			;
	}

}