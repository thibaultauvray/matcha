<?php
// Routes

// $router = new Router($app);

// $router->get('/mvc', 'Pages@index');
// $router->get('/', 'Pages@index')->setName('homepage');
// $router->get('/register', 'Users@register')->setName('register');
// $router->post('/register', 'Users@postRegister')->setName('postRegister');
$app->get('/', 'PagesController:index')->setName('homepage');
$app->get('/register', 'UsersController:register')->setName('register');
$app->post('/register', 'UsersController:postRegister')->setName('postRegister');