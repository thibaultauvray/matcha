<?php


class UsersController extends Controller
{

	/*
	*	Register action
	*/

	public function register($request, $response, $args)
	{
		return $this->app->view->render($response, 'views/users/register.twig');
	}

	public function postRegister($request, $response, $args)
	{
		$validator = $this->app->validator;
		$validator->check('nickname', array('required'));
		$validator->check('mail', array('required', 'isMail', 'isUnique'));
		$validator->check('passwd', array('required', 'isPasswd'));
		$validator->check('lastname', array('required', 'visible'));
		$validator->check('name', array('required', 'visible'));
		if(empty($this->app->flash->getMessages()))
		{
			$_POST['passwd'] = hash('whirlpool', $_POST['passwd']);
			$user = new Users($this->app);
			$_SESSION['login'] = $_POST;
			var_dump($_SESSION['login']);
		}
		 return $this->app->view->render($response, 'views/users/register.twig', array('error' => $validator->error,
		 																			   'form'  => $_POST));
	}

	/*
	*   Users Profil management
	*/

	
}

?>