<?php

namespace Fliglio\Web;

class CurlResponse {

	private $content;
	private $httpCode;
	private $effectiveUrl;
	private $errorNumber;
	private $errorMessage;

	public function getContent() {
		return $this->content;
	}
	public function getHttpCode() {
		return $this->httpCode;
	}
	public function getEffectiveUrl(){
		return $this->effectiveUrl;
	}
	public function getErrorNumber() {
		return $this->errorNumber;
	}
	public function getErrorMessage() {
		return $this->errorMessage;
	}

	public function setContent($content) {
		$this->content = $content;
		return $this;
	}
	public function setHttpCode($httpCode) {
		$this->httpCode = $httpCode;
		return $this;
	}
	public function setEffectiveUrl($effectiveUrl){
		$this->effectiveUrl = $effectiveUrl;
		return $this;
	}
	public function setErrorNumber($errorNumber) {
		$this->errorNumber = $errorNumber;
		return $this;
	}
	public function setErrorMessage($errorMessage) {
		$this->errorMessage = $errorMessage;
		return $this;
	}

}
