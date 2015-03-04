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
	public function getStatus() {
		return $this->status;
	}
	public function getBody() {
		return $this->body;
	}
	public function getHeaders() {
		return $this->headers;
	}
}
