<?php

require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

use Fliglio\Web\RestClient;
use Fliglio\Web\RestResource;
use Fliglio\Web\CurlInterface;
use Fliglio\Web\CurlRequest;
use Fliglio\Web\CurlResponse;
use Fliglio\Web\CurlFactory;
use Fliglio\Web\MediaType;
use Fliglio\Web\Curl;

class RestClientTest extends PHPUnit_Framework_TestCase {

	private $resource;
	private $svc;

	public function setup() {
		CurlFactory::setDriver(new WebRestCurlStub());
		CurlFactory::get()->httpCode = 200;
		CurlFactory::get()->body = '{"fname" : "bob", "lname" : "loblaw"}';

		$this->svc = new RestClient(CurlFactory::get(), 'localhost:8080');

		$this->resource = new RestResource('localhost:8080');
		$this->resource->accept(MediaType::JSON);
	}

	public function tearDown() {
		CurlFactory::setDriver(new Curl());
	}

	public function testSsl() {
		$resource = new RestResource('localhost:8080', true);
		$resource
			->accept(MediaType::JSON)
			->path('/api/user')
			->path(86)
			->get();

		$this->assertEquals(CurlFactory::get()->request->getUrl(), 'https://localhost:8080/api/user/86');
	}

	public function testNonSsl() {
		$this->resource
			->accept(MediaType::JSON)
			->path('/api/user')
			->path(86)
			->get();

		$this->assertEquals(CurlFactory::get()->request->getUrl(), 'http://localhost:8080/api/user/86');
	}

	public function testAddHeaders() {
		$this->resource
			->accept(MediaType::JSON)
			->addHeader('Authorization: LKJSDF21AIU87LK213ADFS;')
			->path('/api/user')
			->path(86)
			->get();

		$headers = array();
		$headers[] = MediaType::getAccept(MediaType::JSON);
		$headers[] = MediaType::getContent(MediaType::JSON);
		$headers[] = "Authorization: LKJSDF21AIU87LK213ADFS;";

		$this->assertEquals(CurlFactory::get()->request->getHeaders(), $headers);
	}

	public function testXmlHeaders() {
		$this->resource
			->accept(MediaType::XML)
			->addHeader('Authorization: LKJSDF21AIU87LK213ADFS;')
			->path('/api/user')
			->path(86)
			->get();

		$headers = array();
		$headers[] = MediaType::getAccept(MediaType::XML);
		$headers[] = MediaType::getContent(MediaType::XML);
		$headers[] = "Authorization: LKJSDF21AIU87LK213ADFS;";

		$this->assertEquals(CurlFactory::get()->request->getHeaders(), $headers);
	}

	public function testJsonDecode() {
		$this->resource
			->accept(MediaType::JSON)
			->path('/api/user')
			->path(86);

		$resp = $this->resource->get();

		$this->assertEquals($resp->getContent(), json_decode(CurlFactory::get()->body, true));
	}

	public function testNoJsonDecodeWithXml() {
		$this->resource
			->accept(MediaType::XML)
			->path('/api/user')
			->path(86);

		$resp = $this->resource->get();

		$this->assertEquals($resp->getContent(), CurlFactory::get()->body);
	}

	/**
	 * @expectedException Fliglio\Web\RestUnknownContentTypeException
	 */
	public function testUnknownContentType() {
		$this->resource->accept('farts');
	}

	public function testPostBodyParams() {
		$params = array('name' => 'hello world');

		$this->resource
			->accept(MediaType::JSON)
			->path('/api/user')
			->post($params);

		$this->assertEquals(CurlFactory::get()->request->getParams(), json_encode($params));
	}

	public function testFilterParamsUrlEncoded() {
		$this->resource
			->accept(MediaType::JSON)
			->path('/api/user')
			->get(array('fname' => 'hello world', 'lname' => 'hello$/`\{}'));

		$this->assertEquals(
			CurlFactory::get()->request->getUrl(), 
			'http://localhost:8080/api/user?fname=hello+world&lname=hello%24%2F%60%5C%7B%7D'
		);
	}


	// Method tests ------------------------------------------------

	public function testGet() {
		$this->resource
			->accept(MediaType::JSON)
			->path('/api/user')
			->path(86)
			->get();

		$this->assertEquals(CurlFactory::get()->request->getMethod(), Curl::GET);
	}

	public function testPost() {
		$this->resource
			->accept(MediaType::JSON)
			->path('/api/user')
			->post(array('hello world'));

		$this->assertEquals(CurlFactory::get()->request->getMethod(), Curl::POST);
	}

	public function testPut() {
		$this->resource
			->accept(MediaType::JSON)
			->path('/api/user')
			->put(array('hello world'));

		$this->assertEquals(CurlFactory::get()->request->getMethod(), Curl::PUT);
	}

	public function testDelete() {
		$this->resource
			->accept(MediaType::JSON)
			->path('/api/user')
			->path(86)
			->delete();

		$this->assertEquals(CurlFactory::get()->request->getMethod(), Curl::DELETE);
	}


	// Error handling tests ------------------------------------------

	/**
	 * @expectedException Fliglio\Web\RestUnknownHttpStatusException
	 */
	public function testUnknownError() {
		CurlFactory::get()->httpCode = 9001;
		$this->resource->accept(MediaType::JSON)->path('/api/user')->get();
	}

	/**
	 * @expectedException Fliglio\Web\RestBadRequestException
	 */
	public function test400() {
		CurlFactory::get()->httpCode = 400;
		$this->resource->accept(MediaType::JSON)->path('/api/user')->get();
	}

	/**
	 * @expectedException Fliglio\Web\RestUnauthorizedException
	 */
	public function test401() {
		CurlFactory::get()->httpCode = 401;
		$this->resource->accept(MediaType::JSON)->path('/api/user')->get();
	}

	/**
	 * @expectedException Fliglio\Web\RestNotFoundException
	 */
	public function test404() {
		CurlFactory::get()->httpCode = 404;
		$this->resource->accept(MediaType::JSON)->path('/api/user')->get();
	}

	/**
	 * @expectedException Fliglio\Web\RestMethodNotAllowedException
	 */
	public function test405() {
		CurlFactory::get()->httpCode = 405;
		$this->resource->accept(MediaType::JSON)->path('/api/user')->get();
	}

	/**
	 * @expectedException Fliglio\Web\RestRequestTimeoutException
	 */
	public function test408() {
		CurlFactory::get()->httpCode = 408;
		$this->resource->accept(MediaType::JSON)->path('/api/user')->get();
	}

	/**
	 * @expectedException Fliglio\Web\RestConflictException
	 */
	public function test409() {
		CurlFactory::get()->httpCode = 409;
		$this->resource->accept(MediaType::JSON)->path('/api/user')->get();
	}

	/**
	 * @expectedException Fliglio\Web\RestLengthRequiredException
	 */
	public function test411() {
		CurlFactory::get()->httpCode = 411;
		$this->resource->accept(MediaType::JSON)->path('/api/user')->get();
	}

	/**
	 * @expectedException Fliglio\Web\RestPreconditionFailedException
	 */
	public function test412() {
		CurlFactory::get()->httpCode = 412;
		$this->resource->accept(MediaType::JSON)->path('/api/user')->get();
	}

	/**
	 * @expectedException Fliglio\Web\RestUnprocessableEntityException
	 */
	public function test422() {
		CurlFactory::get()->httpCode = 422;
		$this->resource->accept(MediaType::JSON)->path('/api/user')->get();
	}

	/**
	 * @expectedException Fliglio\Web\RestInternalServerErrorException
	 */
	public function test500() {
		CurlFactory::get()->httpCode = 500;
		$this->resource->accept(MediaType::JSON)->path('/api/user')->get();
	}

	/**
	 * @expectedException Fliglio\Web\RestNotImplementedException
	 */
	public function test501() {
		CurlFactory::get()->httpCode = 501;
		$this->resource->accept(MediaType::JSON)->path('/api/user')->get();
	}

	/**
	 * @expectedException Fliglio\Web\RestBadGatewayException
	 */
	public function test502() {
		CurlFactory::get()->httpCode = 502;
		$this->resource->accept(MediaType::JSON)->path('/api/user')->get();
	}

	/**
	 * @expectedException Fliglio\Web\RestServiceUnavailableException
	 */
	public function test503() {
		CurlFactory::get()->httpCode = 503;
		$this->resource->accept(MediaType::JSON)->path('/api/user')->get();
	}

	/**
	 * @expectedException Fliglio\Web\RestGatewayTimeoutException
	 */
	public function test504() {
		CurlFactory::get()->httpCode = 504;
		$this->resource->accept(MediaType::JSON)->path('/api/user')->get();
	}
}


class WebRestCurlStub implements CurlInterface {

	public $request;
	public $httpCode;
	public $body;

	public function request(CurlRequest $request) {
		$response = new CurlResponse();
		$this->request = $request;

		$response->setHttpCode($this->httpCode);
		$response->setContent($this->body);

		return $response;
	}
}

