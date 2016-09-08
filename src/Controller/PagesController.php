<?php

class PagesController extends Controller
{
	public function index()
	{
		$em = new Users($this->app);
		$pod = $em->delete(2);
		return $this->app->view->render($this->response, 'views/homepage.twig');
	}
}

?>