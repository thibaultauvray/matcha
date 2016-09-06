<?php

class Router
{
	protected $app;

	public function __construct($app)
	{
		$this->app = $app;
	}

	public function get($url, $action)
	{
		return $this->app->get($url, function($request, $response, $args) use ($action){
			$actions = explode('@', $action);
			$controller_name = $actions[0] . "Controller";
			$actions = $actions[1];
			$controller = new $controller_name($request, $response, $this);
			call_user_func_array([$controller, $actions], func_get_args());
		});
	} 

}

?>