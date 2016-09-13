<?php 

class baseURL
{
	private $baseURL;

	public $imageURL;

	public function __construct()
	{
		$this->baseURL = __DIR__ . "/../../";
		$this->imageURL = $this->baseURL . "public/img/";
	}

	public function getBaseURL()
	{
		return $this->baseURL;
	}

	public function getImageURL()
	{
		return $this->baseURL() . "img/";
	}
}

?>