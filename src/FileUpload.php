<?php


namespace Fliglio\Web;


class FileUpload {

	/**
	 * The original name of the file on the client machine
	 * @var string
	 */
	private $name;

	/**
	 * The mime type of the file, if the browser provided this information
	 * e.g. image/gif
	 * @var string
	 */
	private $type;

	/**
	 * The size, in bytes, of the uploaded file
	 * @var string
	 */
	private $size;

	/**
	 * The temporary filename of the file in which the uploaded file was stored on the server
	 * @var string
	 */
	private $tmpName;

	/**
	 * The error code associated with this file upload
	 * @var string
	 */
	private $error;

	/**
	 * FileUpload constructor.
	 * raw data from $_FILES[$paramName] where $paramName is what your injected variable is named
	 * @param array $fileData
	 */
	public function __construct(array $fileData) {
		$this->name = $this->optional($fileData, 'name');
		$this->type = $this->optional($fileData, 'type');
		$this->size = $this->optional($fileData, 'size');
		$this->tmpName = $this->optional($fileData, 'tmp_name');
		$this->error = $this->optional($fileData, 'error');
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @return string
	 */
	public function getSize() {
		return $this->size;
	}

	/**
	 * @return string
	 */
	public function getTmpName() {
		return $this->tmpName;
	}

	/**
	 * @return string
	 */
	public function getError() {
		return $this->error;
	}

	/**
	 * @return bool
	 */
	public function hasError() {
		return $this->getError() == UPLOAD_ERR_OK && is_uploaded_file($this->getTmpName());
	}

	/**
	 * @return string
	 */
	public function getErrorMessage() {
		switch ($this->getError()) {
			case UPLOAD_ERR_INI_SIZE:
				return "The uploaded file exceeds the upload_max_filesize directive in php.ini";
			case UPLOAD_ERR_FORM_SIZE:
				return "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
			case UPLOAD_ERR_PARTIAL:
				return "The uploaded file was only partially uploaded";
			case UPLOAD_ERR_NO_FILE:
				return "No file was uploaded";
			case UPLOAD_ERR_NO_TMP_DIR:
				return "Missing a temporary folder";
			case UPLOAD_ERR_CANT_WRITE:
				return "Failed to write file to disk";
			case UPLOAD_ERR_EXTENSION:
				return "File upload stopped by extension";
		}
		return "Unknown upload error";
	}

	private function optional($fileData, $field) {
		return array_key_exists($field, $fileData) ? $fileData[$field] : '';
	}

}