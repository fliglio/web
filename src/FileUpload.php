<?php


namespace Fliglio\Web;


class FileUpload {

	/** @var array */
	private $fileData = [];

	public function __construct(array $fileData) {
		$this->fileData = $fileData;
	}


}