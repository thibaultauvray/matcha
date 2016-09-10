<?php


class UsersController extends Controller
{

	/*
	* 	SIGN IN / SIGN OUT ACTION 
	*/

	public function signout($request, $response, $args)
	{
		session_destroy();
		return $response->withStatus(302)->withHeader('Location', $this->app->router->pathFor('homepage'));
	}

	public function signin($request, $response, $args)
	{
		$em = new Users($this->app);
		if (!$em->checkLog($_POST))
		{
			$this->app->flash->addMessage('error', 'Utilisateur non trouve');
		}
		return $response->withStatus(302)->withHeader('Location', $this->app->router->pathFor('homepage'));

	}
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
		if(empty($validator->error))
		{
			$_POST['passwd'] = hash('whirlpool', $_POST['passwd']);
			$user = new Users($this->app);
			$_SESSION['login'] = $_POST;
			$id = $user->insert($_POST);
			$_SESSION['login']['id'] = $id;
			return $response->withStatus(302)->withHeader('Location', $this->app->router->pathFor('editProfil', array('id' => $id)));
		}
		 return $this->app->view->render($response, 'views/users/register.twig', array('error' => $validator->error,
		 																			   'form'  => $_POST));
	}

	/*
	*   Users Profil management
	*/

	public function editProfil($request, $response, $args)
	{
		return $this->app->view->render($response, 'views/users/edit.twig');
	}

}

?>