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
		$us = $em->checkLog($_POST);
		if ($us == false)
		{
			$this->app->flash->addMessage('error', 'Utilisateur non trouve');
		}
		else
		{
			$_SESSION['login'] = $us;
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
		$users = new Users($this->app);
		$user = $users->findById($args['id']);
		$userImage = $users->getImage($args['id']);
		$userInterest = $users->getStringInterest($args['id']);
		return $this->app->view->render($response, 'views/users/edit.twig', array('args' => $args,
																				  'user' => $user,
																				  'interest' => $userInterest,
																				  'usersImage' => $userImage ));
	}

	public function updateUsers($id, $form, $image, $baseUrl = NULL)
	{
		$user = new Users($this->app);
		$userImage = new UsersImage($this->app);
		$userInteret = new UsersInterest($this->app);
		if ($image == true)
		{
			$profil = 1;
			foreach ($baseUrl as $url) {
				$userImage->insert(array(
					'url' => $url,
					'isprofil' => $profil,
					'id_users' => $id 						
					));
				$profil = 0;
			}
		}
		$interest = explode(',', $form['interet']);
		$userInteret->deleteSpecial('id_users', $id);
		foreach ($interest as $int) {
			$userInteret->insert(array(
				'interest' => $int,
				'id_users' => $id));
		}
		$user->update($id, array('age' => $form['age'],
							'gender' => $form['sexe'],
							'orientation' => $form['orientation'])); 
	}

	public function postEditProfil($request, $response, $args)
	{

		$validator = $this->app->validator;
		$validator->check('age', array('isNumeric'));
		if (empty($validator->error) && $_FILES['image']['size'][0] > 0)
		{
			$users = new Users($this->app);
			$count = $users->getCountImage($args['id']);
			$uploadFile = new Upload($request->getUploadedFiles()['image']);
			$uploadFile->upload($count);
			$this->updateUsers($args['id'], $_POST, true, $uploadFile->baseUrl);
			foreach ($uploadFile->error as $error) {
				$this->app->flash->addMessage('error', $error);
			}
			return $response->withStatus(302)->withHeader('Location', $this->app->router->pathFor('editProfil', array('id' => $args['id'])));
		}
		else if(empty($validator->error) && $_FILES['image']['size'][0] <= 0)
		{
			$this->updateUsers($args['id'], $_POST, false);
			return $response->withStatus(302)->withHeader('Location', $this->app->router->pathFor('editProfil', array('id' => $args['id'])));

		}
		return $response->withStatus(302)->withHeader('Location', $this->app->router->pathFor('editProfil', array('id' => $args['id'])));

	}

	/*
	* 	AJAX CALL
	*	// Verification ID SESSION
	*/

	public function updateZipCode($request, $response, $args)
	{
		$usersLocation = new UsersLocation($this->app);
		$id = $usersLocation->find('id_users', $_POST['id']);
		if (empty($id))
		{
			$usersLocation->insert(array('id_users' => $_POST['id'],
										 'longitude' => $_POST['longitude'],
										 'latitude' => $_POST['latitude'],
										 'zipCode' => $_POST['zip'])
			);
		}
		else
		{
			$usersLocation->update($id[0]['id'], array('id_users' => $_POST['id'],
										 'longitude' => $_POST['longitude'],
										 'latitude' => $_POST['latitude'],
										 'zipCode' => $_POST['zip'])
			);
		}
	}

	public function getId($request, $response, $args)
	{
		$body = array('id' => $_SESSION['login']['id']);
		$response->withHeader('Content-type', 'application/json');
		$response->withJson($body);
		return $response;
	}

}

?>