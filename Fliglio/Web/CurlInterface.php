<?php

namespace Fliglio\Web;

interface CurlInterface {

	/**
	 * @param CurlRequest $request 
	 * @return CurlResponse
	 */
	public function request(CurlRequest $request);

}
