<?php

class Controller
{
	protected $app;
	protected $container;
	protected $request;
	protected $response;

	public function __construct($request, $response, $app)
	{
		$this->app = $app;
		$this->response = $response;
		$this->request = $request;
		
	}
}
?>