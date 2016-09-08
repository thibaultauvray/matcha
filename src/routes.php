<?php
// Routes

$router = new Router($app);

$router->get('/mvc', 'Pages@index');
$router->get('/', 'Pages@index')->setName('homepage');
$router->get('/register', 'Users@register')->setName('register');
$router->post('/register', 'Users@postRegister')->setName('postRegister');
