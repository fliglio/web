<?php

namespace Fliglio\Web;

class CurlRequest {

	private $method;
	private $url;
	private $params;
	private $headers;
	private $options;

	public function __construct($method, $url, $params = array(), $headers = array()) {
		$this->method  = $method;
		$this->url     = $url;
		$this->params  = $params;
		$this->headers = $headers;
		$this->options = array();
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
	public function getParams() {
		return $this->params;
	}
	public function getOptions(){
		return $this->options;
	}

	public function setOption($key, $value){
		$this->options[$key] = $value;
		return $this;
	}
	public function setHeaders(array $headers){
		$this->headers = $headers;
		return $this;
	}

}