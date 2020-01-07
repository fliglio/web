<?php

namespace Fliglio\Web\Client;

use Fliglio\Http\RequestWriter;
use Fliglio\Http\ResponseReader;
use Fliglio\Http\Http;
use Fliglio\Http\HttpClient;

class BasicClient implements HttpClient {

	public function get($url, array $headers = array()) {
		$b = $this->getBuilderCommon($url, $headers);
		$b->method(Http::METHOD_GET);

		return $this->makeRequest($b->build());
	}
	public function put($url, $body = null, array $headers = array()) {
		$b = $this->getBuilderCommon($url, $headers);
		$b->method(Http::METHOD_PUT);
		$b->body($body);

		return $this->makeRequest($b->build());
	}
	public function post($url, $body = null, array $headers = array()) {
		$b = $this->getBuilderCommon($url, $headers);
		$b->method(Http::METHOD_POST);
		$b->body($body);

		return $this->makeRequest($b->build());
	}
	public function delete($url, array $headers = array()) {
		$b = $this->getBuilderCommon($url, $headers);
		$b->method(Http::METHOD_DELETE);

		return $this->makeRequest($b->build());
	}

	private function getBuilderCommon($url, array $headers = array()) {
		$b = new BasicRequestBuilder();
		$b->url($url);
		foreach ($headers as $h) {
			$b->header($h);
		}
		return $b;
	}
	/**
	 * @param RequestWriter $request
	 * @return ResponseReader
	 */
	public function makeRequest(RequestWriter $request) {
		// $response = new CurlResponse();

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $request->getUrl()); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, $request->getHeaders());

		if ($request->getMethod() == Http::METHOD_POST) {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $request->getBody());

		} else if ($request->getMethod() == Http::METHOD_PUT) {
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper(Http::METHOD_PUT));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $request->getBody());

		} else if ($request->getMethod() == Http::METHOD_DELETE) {
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper(Http::METHOD_DELETE));
		}

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);


		$result = curl_exec($ch);
		$headers = array();
		$body = null;

		if ($result !== false) {
			$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			$headers = $this->parseHeaders(substr($result, 0, $headerSize));
			$body = substr($result, $headerSize);
		}

		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close($ch);

		return new BasicResponse($status, $body, $headers);
	}

	private function parseHeaders($headerStr) {
		$headerLines = explode("\n", $headerStr);
		$headers = array_map(
			function($h) {
				return trim($h);
			}, $headerLines 
		);
		return array_filter($headers);
	}

}
