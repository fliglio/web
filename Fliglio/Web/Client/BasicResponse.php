<?php

namespace Fliglio\Web\Client;

use Fliglio\Http\ResponseReader;

class BasicResponse implements ResponseReader {

	private $status;
	private $body;
	private $headers;

	public function __construct($status = 0, $body = null, $headers = array()) {
		$this->status = $status;
		$this->body = $body;
		$this->headers = $headers;
	}
	public function setStatus($status) {
		$this->status = $status;
	}
	public function getStatus() {
		return $this->status;
	}
	public function setBody($body) {
		$this->body = $body;
	}
	public function getBody() {
		return $this->body;
	}
	public function setHeaders(array $headers) {
		$this->headers = $headers;
	}
	public function getHeaders() {
		return $this->headers;
	}
}
