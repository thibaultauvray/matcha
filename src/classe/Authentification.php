<?php

/**
 * Created by PhpStorm.
 * User: tauvray
 * Date: 10/14/16
 * Time: 5:27 PM
 */
class Authentification
{
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function __invoke($request, $response, $next)
    {
        $authorized = ['signin', 'signout', 'homepage', 'register', 'postRegister', 'forget', 'postForget', 'initPass'];
        $route = $request->getAttribute('route');
        $name = $route->getName();
        if ((isset($_SESSION['login']) && !empty($_SESSION['login'])) || (in_array($name, $authorized)))
        {
            $response = $next($request, $response);
            return $response;
        }
        else
        {
            $uri = $request->getUri()->withPath($this->app->router->pathFor('homepage'));
            $this->app->flash->addMessage('fail', 'Vous devez etre connecté pour accéder a cette page');

            return $response = $response->withRedirect($uri, 403);
        }
    }
}