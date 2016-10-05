<?php
// Routes

// Homepage
$app->get('/', 'PagesController:index')->setName('homepage');

// User
$app->get('/signout', 'UsersController:signout')->setName('signout');
$app->post('/', 'UsersController:signin')->setName('signin');
$app->get('/register', 'UsersController:register')->setName('register');
$app->post('/register', 'UsersController:postRegister')->setName('postRegister');

$app->get('/users/view/{id}', 'UsersController:viewProfil')->setName('viewProfil');


$app->get('/edit/{id}', 'UsersController:editProfil')->setName('editProfil');
$app->post('/edit/{id}', 'UsersController:postEditProfil')->setName('postEditProfil');

$app->get('/edit/location/{id}', 'UsersController:editLocation')->setName('editLocation');

// Suggestion recherche

$app->get('/user/view/suggest/{id}', 'UsersController:viewSuggest')->setName('viewSuggest');
$app->post('/user/search', 'UsersController:search')->setName('search');
$app->get('/user/search', 'UsersController:search')->setName('search');

// AJax call 
$app->post('/updateZipCode', 'UsersController:updateZipCode')->setName('updateZipCode');
$app->get('/getId', 'UsersController:getId')->setName('getId');
$app->get('/updateLocation', 'UsersController:updateLocation')->setName('updateLocation');
$app->get('/getCity', 'UsersController:getCity')->setName('getCity');
$app->post('/updateLocationProfil', 'UsersController:updateLocationProfil')->setName('updateLocationProfil');
$app->get('/users/updateLocation/{id}', 'UsersController:updateUsersLocation')->setName('updateUsersLocation');
$app->post('/like', 'NotificationsController:like')->setName('like');
$app->get('/getLike', 'NotificationsController:getLike')->setName('like');