<?php

namespace Fliglio\Web;

class UrlBuilder {

    private $scheme   = null;
    private $host     = null;
    private $port;
    private $user     = null;
    private $pass     = null;
    private $path     = null;
    private $query    = null;
    private $fragment = null;

	public function __construct(Url $url = null) {
		if (!is_null($url)) {
			$this
				->scheme($url->getScheme())
				->host($url->getHost())
				->port($url->getPort())
				->user($url->getUser())
				->pass($url->getPass())
				->path($url->getPath())
				->query($url->getQuery())
				->fragment($url->getFragment());
		}
	}

	public function scheme($scheme) {
		$this->scheme = $scheme;
		return $this;
	}

	public function host($host) {
		$this->host = $host;
		return $this;
	}

	public function port($port) {
		$this->port = $port;
		return $this;
	}

	public function user($user) {
		$this->user = $user;
		return $this;
	}
	public function pass($pass) {
		$this->pass = $pass;
		return $this;
	}

	public function path($path) {
		$this->path = $path;
		return $this;
	}

	public function query($query) {
		$this->query = $query;
		return $this;
	}

	public function fragment($fragment) {
		$this->fragment = $fragment;
		return $this;
	}

	public function build() {
		return new Url($this->scheme, $this->host, $this->port, $this->user, $this->pass, $this->path, $this->query, $this->fragment);
	}

}