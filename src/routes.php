<?php
// Routes

$router = new Router($app);

$router->get('/mvc', 'Pages@index');
$router->get('/', 'Pages@index')->setName('homepage');
