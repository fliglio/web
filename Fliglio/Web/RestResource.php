<?php

namespace Fliglio\Web;

/**
 * Example:
 * RestResource::build('localhost:8080')
 *   ->accept(MediaType::JSON)
 *   ->path('/user')
 *   ->path(1)
 *   ->addFilter('email', 'user@google.com')
 *   ->get();
 * 
 * Turns into: curl -H "Accept: aplication/json;" -X GET http://localhost:8080/user/1?email=user@google.com
 */
class RestResource {

	private $path    = '';
	private $headers = array();
	private $accept  = null;

	public function __construct($host, $ssl = false) {
		$this->client = new RestClient(CurlFactory::get(), $host, $ssl);
	}

	public static function build($host, $ssl = false) {
		$client = new RestClient(CurlFactory::get(), $host, $ssl);

		$resource = new self($client);

		return $resource;
	}


	// RESTful methods -------

	public function get(array $filterParams = array()) {
		return $this->request(new CurlRequest(Curl::GET, $this->getUrl($filterParams)));
	}

	public function post($body) {
		$body = $this->accept == MediaType::JSON ? json_encode($body) : $body;
 		return $this->request(new CurlRequest(Curl::POST, $this->getUrl(), $body));
	}

	public function put($body) {
		$body = $this->accept == MediaType::JSON ? json_encode($body) : $body;
		return $this->request(new CurlRequest(Curl::PUT, $this->getUrl(), $body));
	}

	public function delete() {
		return $this->request(new CurlRequest(Curl::DELETE, $this->getUrl()));
	}


	// Builder Methods -------

	public function path($path) {
		$resource = clone $this;
		$resource->setPath($path);
		return $resource;
	}

	/**
	 * @param MediaType.<string> $mediaType 
	 */
	public function accept($mediaType) {
		// clear headers for fresh start
		$this->headers = array();
		$this->accept  = $mediaType;

		switch ($mediaType) {
			case MediaType::JSON:
			case MediaType::XML:
				$this->headers[] = MediaType::getAccept($mediaType);
				$this->headers[] = MediaType::getContent($mediaType);
				break;
			default:
				throw new RestUnknownContentTypeException($mediaType);
				break;
		}

		return $this;
	}

	public function addHeader($header) {
		$this->headers[] = $header;
		return $this;
	}


	// Helper Methods -----------------

	/**
	 * @param string $path 
	 * @return void
	 */
	private function setPath($path) {
		if (strlen($this->path) > 0) {
			$this->path .= '/';
		}

		$this->path .= rtrim($path, '/');
	}

	/**
	 * @return string
	 */
	private function getUrl(array $filterParams = array()) {
		return $this->client->buildUrl($this->path, $filterParams);
	}

	/**
	 * @param CurlRequest $req 
	 * @return CurlResponse
	 */
	private function request(CurlRequest $req) {
		$this->client->setHeaders($this->headers);

		try {
			$response = $this->client->request($req);

		// More appropriate would be a "finally" - but not till php 5.5
		} catch (RestResponseException $e) {
			// Decode JSON on exception content
			if ($this->accept == MediaType::JSON) {
				$e->setContent(json_decode($e->getContent(), true));
			}
			// re-throw exception
			throw $e;
		}

		// Decode JSON on response body
		if ($this->accept == MediaType::JSON) {
			$response->setContent(json_decode($response->getContent(), true));
		}

		return $response;
	}

}

