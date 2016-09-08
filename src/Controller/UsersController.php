<?php


class UsersController extends Controller
{
	public function register($request, $response, $args)
	{
		return $this->app->view->render($response, 'views/users/register.twig');
	}

	public function postRegister($request, $response, $args)
	{
		$validator = $this->app->validator;
		$validator->check('nickname', array('required'));
		$validator->check('mail', array('required', 'isMail'));
		$validator->check('passwd', array('required', 'isPasswd'));
		$validator->check('lastname', array('required', 'visible'));
		$validator->check('name', array('required', 'visible'));
		if(empty($this->app->flash->getMessages()))
		{
		}
		 return $response->withStatus(302)->withHeader('Location', $this->app->router->pathFor('register'));
	}
}

?>