<?php


namespace Fliglio\Web;


class FileUploadTest extends \PHPUnit_Framework_TestCase {

	public function testValid_FileUpload() {
		$file = new FileUpload([
			"name" => "foo.jpg",
			"type" => "image/jpg",
			"size" => 12345,
			"tmp_name" => "/tmp/123/asd23f",
			"error" => UPLOAD_ERR_OK,
		]);


		$this->assertEquals("foo.jpg", $file->getName());
		$this->assertEquals("image/jpg", $file->getType());
		$this->assertEquals(12345, $file->getSize());
		$this->assertEquals("/tmp/123/asd23f", $file->getTmpName());
		$this->assertEquals(UPLOAD_ERR_OK, $file->getError());
	}


}