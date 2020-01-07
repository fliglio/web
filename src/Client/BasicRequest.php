<?php

namespace Fliglio\Web\Client;

use Fliglio\Http\RequestWriter;

class BasicRequest implements RequestWriter {

	private $method;
	private $url;
	private $headers;
	private $body;

	public function __construct($method, $url, $headers = [], $body = '') {
		$this->method  = $method;
		$this->url     = $url;
		$this->headers = $headers;
		$this->body    = $body;
	}

	public function getMethod() {
		return $this->method;
	}

	public function getUrl() {
		return $this->url;
	}
	
	public function getHeaders() {
		return $this->headers;
	}
	
	public function getBody(){
		return $this->body;
	}

}