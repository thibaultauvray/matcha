<?php
// Routes

// Homepage
$app->get('/', 'PagesController:index')->setName('homepage');

// User
$app->get('/signout', 'UsersController:signout')->setName('signout');
$app->post('/', 'UsersController:signin')->setName('signin');
$app->get('/register', 'UsersController:register')->setName('register');
$app->post('/register', 'UsersController:postRegister')->setName('postRegister');

$app->get('/edit/{id}', 'UsersController:editProfil')->setName('editProfil');
$app->post('/edit/{id}', 'UsersController:postEditProfil')->setName('postEditProfil');
