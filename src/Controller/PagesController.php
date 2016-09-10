<?php

class PagesController extends Controller
{
	public function index($request, $response, $args)
	{
		var_dump($this->app->flash->getMessages());

		$em = new Users($this->app);
		$pod = $em->delete(2);
		return $this->app->view->render($response, 'views/homepage.twig');
	}
}

?>