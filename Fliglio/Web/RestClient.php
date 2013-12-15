<?php

namespace Fliglio\Web;

require_once dirname(__FILE__).'/inc/restexceptions.php';

/**
 * Restful client api for JSON services
 */
class RestClient {

	// Non HTTP 200 status code exception types
	private static $exceptions = array(
		400 => 'Fliglio\Web\RestBadRequestException',
		401 => 'Fliglio\Web\RestUnauthorizedException',
		403 => 'Fliglio\Web\RestForbiddenException',
		404 => 'Fliglio\Web\RestNotFoundException',
		405 => 'Fliglio\Web\RestMethodNotAllowedException',
		408 => 'Fliglio\Web\RestRequestTimeoutException',
		409 => 'Fliglio\Web\RestConflictException',
		411 => 'Fliglio\Web\RestLengthRequiredException',
		412 => 'Fliglio\Web\RestPreconditionFailedException',
		422 => 'Fliglio\Web\RestUnprocessableEntityException',
		500 => 'Fliglio\Web\RestInternalServerErrorException',
		501 => 'Fliglio\Web\RestNotImplementedException',
		502 => 'Fliglio\Web\RestBadGatewayException',
		503 => 'Fliglio\Web\RestServiceUnavailableException',
		504 => 'Fliglio\Web\RestGatewayTimeoutException',
	);

	private $host;
	private $ssl;
	private $curl;
	private $headers;

	/**
	 * @param CurlInterface $curlDriver 
	 * @param string $host 
	 * @param string $ssl 
	 * @throws RestUnknownContentTypeException
	 */
	public function __construct(CurlInterface $curlDriver, $host, $ssl = false) {
		$this->curl = $curlDriver;
		$this->host = $host;
		$this->ssl  = $ssl;
	}

	public function setHeaders(array $headers) {
		$this->headers = $headers;
	}

	/**
	 * @param CurlResponse $resp 
	 * @throws CurlResponse $resp 
	 * @throws RestException
	 * @return CurlResponse
	 */
	public function request(CurlRequest $req) {
		$req->setHeaders($this->headers);

		$resp = $this->curl->request($req);

		// If not an "Ok" http status, map the code to an exception and throw
		if ($resp->getHttpCode() != 200 && $resp->getHttpCode() != 201 && $resp->getHttpCode() != 202) {
			$msg = "Response code " . $resp->getHttpCode() . " from " . $req->getUrl();

			// Find exception class name
			if (!isset(self::$exceptions[$resp->getHttpCode()])) {
				$exception = new RestUnknownHttpStatusException($msg);
			} else {
				$exception = new self::$exceptions[$resp->getHttpCode()]($msg);
			}

			// Set response content on exception
			$exception->setContent($resp->getContent());

			throw $exception;
		}

		return $resp;
	}

	/**
	 * Formats URL based on the resource's params
	 * 
	 * @param RestResource $resource 
	 * @return string
	 */
	public function buildUrl($url, $filterParams) {
		$query    = is_array($filterParams) ? http_build_query($filterParams) : null;
		$protocol = $this->ssl ? 'https://' : 'http://';

		// Apply filter params if exists
		if (strlen($query) > 0) {
			$url .= '?'.$query;
		}

		// Assemble and return (string)URL
		return $protocol.$this->host.$url;
	}

}
