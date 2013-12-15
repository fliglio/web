<?php

namespace Fliglio\Web;

class Curl implements CurlInterface {

	const POST    = 'post';
	const GET     = 'get';
	const PUT     = 'put';
	const DELETE  = 'delete';
	const OPTIONS = 'options';

	/**
	 * @param CurlRequest $request
	 * @return CurlResponse
	 */
	public function request(CurlRequest $request) {
		$response = new CurlResponse();

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $request->getUrl()); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, $request->getHeaders());

		$h = $request->getHeaders();

		$postFields = is_array($request->getParams()) ? http_build_query($request->getParams()) : $request->getParams();

		if ($request->getMethod() == self::POST) {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);

		} else if ($request->getMethod() == self::PUT) {
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper(self::PUT));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);

		} else if ($request->getMethod() == self::DELETE) {
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper(self::DELETE));
		}

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);

		foreach ($request->getOptions() as $option => $value) {
			curl_setopt($ch, $option, $value);
		}

		$response->setContent(curl_exec($ch));

		if (curl_errno($ch) != 0) {
			$response->setErrorNumber(curl_errno($ch));
			$response->setErrorMessage(curl_error($ch));
		}
		
		$info = curl_getinfo($ch);
		$response->setHttpCode($info['http_code']);

		$effectiveUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
		$response->setEffectiveUrl($effectiveUrl);

		curl_close($ch);

		return $response;
	}

}
