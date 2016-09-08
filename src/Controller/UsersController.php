<?php

class UsersController extends Controller
{
	public function register()
	{
		return $this->app->view->render($this->response, 'views/users/register.twig');
	}

	public function postRegister()
	{
		$validator = $this->app->validator;
		$validator->check('nickname', array('required'));
		$validator->check('mail', array('required', 'isMail'));
		$validator->check('passwd', array('required', 'isPasswd'));
		$validator->check('lastname', array('required', 'visible'));
		$validator->check('name', array('required', 'visible'));
			echo $this->app->router->pathFor('register');
		
		if(empty($this->app->flash->getMessages()))
		{
			echo $this->app->router->pathFor('register');
		}
		return $this->response->withRedirect($this->app->router->pathFor('register'));
	}
}

?>