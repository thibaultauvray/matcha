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
        $authorized = ['signin', 'signout', 'homepage', 'register', 'postRegister', 'forget', 'postForget', 'initPass', 'postInitPass', 'fillDB'];
        $route = $request->getAttribute('route');
        if(!$route)
        {
            $this->app->flash->addMessage('fail', 'Une erreures a ete trouvée');
            return $response = $response->withRedirect($request->getUri()->withPath($this->app->router->pathFor('homepage'), 403 ));
        }

        $name = $route->getName();
        if(strpos($request->getUri(), '/admin/') != false && (isset($_SESSION['login']) && !empty($_SESSION['login'])) && $_SESSION['login']['isAdmin'] != 1 )
        {
            $uri = $request->getUri()->withPath($this->app->router->pathFor('homepage'));
            $this->app->flash->addMessage('fail', 'Vous devez etre connecté pour accéder a cette page');

            return $response = $response->withRedirect($uri, 403);
        }

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