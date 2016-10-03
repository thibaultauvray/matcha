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
        } else
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

    public function search($request, $response, $args)
    {
        $users = new Users($this->app);
        $id = $this->getUserId();
        $userSuggest = $users->findSearch($_POST['terms'], $id);
        $route = $request->getAttribute('route');
        $name = $route->getName();

        return $this->app->view->render($response, 'views/users/suggest.twig', array('suggest'   => $userSuggest,
                                                                                     'routeName' => $name,
                                                                                     'data'      => $_POST['terms']));
    }

    public function postRegister($request, $response, $args)
    {
        $validator = $this->app->validator;
        $validator->check('nickname', array('required'));
        $validator->check('mail', array('required', 'isMail', 'isUnique'));
        $validator->check('passwd', array('required', 'isPasswd'));
        $validator->check('lastname', array('required', 'visible'));
        $validator->check('name', array('required', 'visible'));
        if (empty($validator->error))
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
        $usersLocation = new UsersLocation($this->app);
        $location = $usersLocation->findOne('id_users', $args['id']);
        $user = $users->findById($args['id']);
        $userImage = $users->getImage($args['id']);
        $userInterest = $users->getStringInterest($args['id']);
        var_dump($userInterest);

        return $this->app->view->render($response, 'views/users/edit.twig', array('args'       => $args,
                                                                                  'user'       => $user,
                                                                                  'interest'   => $userInterest,
                                                                                  'usersImage' => $userImage,
                                                                                  'location'   => $location));
    }

    public function updateUsersLocation($request, $response, $args)
    {
        $usersLocation = new UsersLocation($this->app);
        $location = $usersLocation->findOne('id_users', $args['id']);
        if (!$location)
        {
            $usersLocation->insert(array('id_users' => $args['id']));
        }

        return $this->app->view->render($response, 'views/users/editLocation.twig', array('args'     => $args,
                                                                                          'location' => $location,
                                                                                          'refere'   => $_SERVER['HTTP_REFERER']));

    }

    public function viewProfil($request, $response, $args)
    {
        $id = $args['id'];
        $usersLocation = new UsersLocation($this->app);
        $users = new Users($this->app);

        $this->upPopularity($id, 5);
        $userSuggest = $users->findSuggest($id);
        $interest = $users->getInterest($id);
        $location = $usersLocation->findOne('id_users', $id);
        $user = $users->findById($id);
        $imagePics = $users->getImageProfil($id);


        return $this->app->view->render($response, 'views/users/users.twig', array('users'     => $user,
                                                                                   'imgProfil' => $imagePics,
                                                                                   'location'  => $location,
                                                                                   'interet'   => $interest,
                                                                                   'suggest'   => $userSuggest));
    }


    public function updateUsers($id, $form, $image, $baseUrl = NULL)
    {
        $user = new Users($this->app);
        $userImage = new UsersImage($this->app);
        $userInteret = new UsersInterest($this->app);
        $userInt = new Users_UsersInterest($this->app);
        if ($image == true)
        {
            foreach ($baseUrl as $url)
            {
                if (!$user->getImageProfil($id))
                    $bool = 1;
                else
                    $bool = 0;
                $userImage->insert(array(
                    'url'      => $url,
                    'isprofil' => $bool,
                    'id_users' => $id
                ));
                $bool = 0;
            }
        }
        $interest = array_unique(explode(',', trim($form['interet'])));
        $arrInterest = $user->getInterest($id);
        $userInt->deleteAllInterest($_SESSION['login']['id']);
        foreach ($interest as $int)
        {
            if (!empty(trim($int)))
            {
                $int = trim($int);
                $id_interest = $userInteret->findOne('interest', $int);
                if (empty($id_interest))
                {
                    $id_int = $userInteret->insert(array('interest' => $int));
                    $userInt->insert(array('id_users'    => $_SESSION['login']['id'],
                                           'id_interest' => $id_int));
                } else
                {
                    if (empty($userInt->interestExist($_SESSION['login']['id'], $id_interest['id'])))
                    {
                        $userInt->insert(array('id_users'    => $_SESSION['login']['id'],
                                               'id_interest' => $id_interest['id']));
                    }
                }
            }
        }
        $user->update($id, array('age'         => $form['age'],
                                 'gender'      => $form['sexe'],
                                 'orientation' => $form['orientation']));
    }

    public function postEditProfil($request, $response, $args)
    {

        $validator = $this->app->validator;
        if (empty($validator->error) && $_FILES['image']['size'][0] > 0)
        {
            $users = new Users($this->app);
            $count = $users->getCountImage($args['id']);
            $uploadFile = new Upload($request->getUploadedFiles()['image']);
            $uploadFile->upload($count);
            $this->updateUsers($args['id'], $_POST, true, $uploadFile->baseUrl);
            foreach ($uploadFile->error as $error)
            {
                $this->app->flash->addMessage('error', $error);
            }

            return $response->withStatus(302)->withHeader('Location', $this->app->router->pathFor('editProfil', array('id' => $args['id'])));
        } else if (empty($validator->error) && $_FILES['image']['size'][0] <= 0)
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
    public function updateLocationProfil($request, $reponse, $args)
    {
        $usersLocation = new UsersLocation($this->app);

        $usersLocation->updateLink('id_users', $_SESSION['login']['id'], array('city'      => $_POST['city'],
                                                                               'latitude'  => $_POST['lat'],
                                                                               'longitude' => $_POST['lng']));
    }

    public function flashProfil($request, $response, $args)
    {
        $this->app->flash->addMessage('error', 'Utilisateur non trouve');

    }

    public function updateLocation($request, $response, $args)
    {
        $usersLocation = new UsersLocation($this->app);

        $location = $usersLocation->find('id_users', $_GET['id'])[0];
        $date = DateTime::createFromFormat('d/m/Y H:i:s', $location['updated_at']);
        $dateNow = new DateTime('now');

        $interval = $dateNow->diff($date);
        $minInter = $interval->format('%I');
        if (intval($minInter) > 30)
        {
            $body = array('updated' => true);
        } else
        {
            $body = array('updated' => false);
        }
        $response->withHeader('Content-type', 'application/json');
        $response->withJson($body);

        return $response;
    }


    /*
     * View suggest
     */
    public function viewSuggest($request, $response, $args)
    {
        $users = new Users($this->app);
        $id = $args['id'];
        $userSuggest = $users->findSuggest($id);

        return $this->app->view->render($response, 'views/users/suggest.twig', array('suggest' => $userSuggest));
    }


    public function updateZipCode($request, $response, $args)
    {
        $usersLocation = new UsersLocation($this->app);
        $id = $usersLocation->find('id_users', $_POST['id']);
        $city = $_POST['city'];
        if (strtolower($_POST['city']) == "paris")
        {
            $city = "Paris" . " " . substr($_POST['zip'], 3);
        }
        if (empty($id))
        {
            $usersLocation->insert(array('id_users'  => $_POST['id'],
                                         'longitude' => $_POST['longitude'],
                                         'latitude'  => $_POST['latitude'],
                                         'zipCode'   => $_POST['zip'],
                                         'city'      => $city)
            );
        } else
        {
            $usersLocation->update($id[0]['id'], array('id_users'  => $_POST['id'],
                                                       'longitude' => $_POST['longitude'],
                                                       'latitude'  => $_POST['latitude'],
                                                       'zipCode'   => $_POST['zip'],
                                                       'city'      => $city)
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

    public function getCity($request, $response, $args)
    {
        $users = new Users($this->app);
        $city = $users->getCity($_SESSION['login']['id']);
        $body = array('city' => $city['city']);
        $response->withHeader('Content-type', 'application/json');
        $response->withJson($body);

        return $response;
    }

}

?>