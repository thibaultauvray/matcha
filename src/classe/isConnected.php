<?php

/**
 * Created by PhpStorm.
 * User: tauvray
 * Date: 10/12/16
 * Time: 3:10 PM
 */
class isConnected
{
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function __invoke($request, $response, $next)
    {
        if (isset($_SESSION['login']) && !empty($_SESSION['login']))
        {
            $idUser = $_SESSION['login']['id'];
            $users = new Users($this->app);
            $users->updatedLogin($idUser);
        }
        $response = $next($request, $response);
        $response->getBody()->write('AFTER');

        return $response;
    }

}