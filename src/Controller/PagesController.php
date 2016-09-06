<?php

class PagesController extends Controller
{
	public function index()
	{
		$em = new Model($this->app);
		$pod = $em->find("d", "D", "d");
		var_dump($pod);
		return $this->app->view->render($this->response, 'cc.twig');
	}
}

?>