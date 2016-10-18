<?php

class PagesController extends Controller
{
	public function index($request, $response, $args)
	{

		$em = new Users($this->app);
        $user = $em->getHome();
		return $this->app->view->render($response, 'views/homepage.twig', array('suggest' => $user));
	}
}

?>