<?php

class PagesController extends Controller
{
	public function index()
	{
		$em = new Users($this->app);
		$pod = $em->insert(array(
				'name' => 'Poil',
				'mail' => 'carotte'
			));
		return $this->app->view->render($this->response, 'cc.twig');
	}
}

?>