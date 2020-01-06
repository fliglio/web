<?php

namespace Fliglio\Web\Client;

class BasicRequestBuilder {

	private $method = null;
	private $url = null;
	private $headers = array();
	private $body = null;

	public function __construct() {
	}

	public function method($method) {
		$this->method = $method;
		return $this;
	}
	public function url($url) {
		$this->url = $url;
		return $this;
	}
	public function header($header) {
		$this->headers[] = $header;
		return $this;
	}
	public function body($body) {
		$this->body = $body;
		return $this;
	}


	public function build() {
		return new BasicRequest($this->method, $this->url, $this->headers, $this->body);
	}
}