<?php

namespace Fliglio\Web;

class RestException extends \Exception {}
class RestUnknownContentTypeException extends RestException {}

class RestResponseException extends RestException {
	private $content;
	public function setContent($content) {
		$this->content = $content;
	}
	public function getContent() {
		return $this->content;
	}
}


// Default Exception

class RestUnknownHttpStatusException extends RestResponseException {}


// Client Errors

class RestClientException extends RestResponseException {}
class RestBadRequestException extends RestClientException {}
class RestUnauthorizedException extends RestClientException {}
class RestNotFoundException extends RestClientException {}
class RestMethodNotAllowedException extends RestClientException {}
class RestRequestTimeoutException extends RestClientException {}
class RestConflictException extends RestClientException {}
class RestLengthRequiredException extends RestClientException {}
class RestPreconditionFailedException extends RestClientException {}
class RestUnprocessableEntityException extends RestClientException {}
class RestForbiddenException extends RestClientException {}


// Server Errors

class RestServerException extends RestResponseException {}
class RestInternalServerErrorException extends RestServerException {}
class RestNotImplementedException extends RestServerException {}
class RestBadGatewayException extends RestServerException {}
class RestServiceUnavailableException extends RestServerException {}
class RestGatewayTimeoutException extends RestServerException {}