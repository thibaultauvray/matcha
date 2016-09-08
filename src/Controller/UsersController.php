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
		var_dump($this->getMessages());
		return $this->app->view->render($this->response, 'views/users/register.twig', array('OK' => 'MDR'));
	}
}

?>