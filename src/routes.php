<?php
// Routes

// Homepage
$app->get('/', 'PagesController:index')->setName('homepage');

// User
$app->get('/signout', 'UsersController:signout')->setName('signout');
$app->post('/', 'UsersController:signin')->setName('signin')->add(new isConnected($app->getContainer()));
$app->get('/register', 'UsersController:register')->setName('register')->add(new isConnected($app->getContainer()));
$app->post('/register', 'UsersController:postRegister')->setName('postRegister');

$app->get('/users/view/{id}', 'UsersController:viewProfil')->setName('viewProfil')->add(new isConnected($app->getContainer()));

$app->get('/view/history/{id}', 'UsersController:viewHistory')->setName('viewHistory')->add(new isConnected($app->getContainer()));
$app->get('/view/like/{id}', 'UsersController:viewLike')->setName('viewLike')->add(new isConnected($app->getContainer()));

$app->get('/edit/{id}', 'UsersController:editProfil')->setName('editProfil')->add(new isConnected($app->getContainer()));
$app->post('/edit/{id}', 'UsersController:postEditProfil')->setName('postEditProfil')->add(new isConnected($app->getContainer()));

$app->get('/edit/location/{id}', 'UsersController:editLocation')->setName('editLocation')->add(new isConnected($app->getContainer()));

// Suggestion recherche

$app->get('/user/view/suggest/{id}', 'UsersController:viewSuggest')->setName('viewSuggest')->add(new isConnected($app->getContainer()));
$app->post('/user/search', 'UsersController:search')->setName('search');
$app->get('/user/search', 'UsersController:search')->setName('search')->add(new isConnected($app->getContainer()));

// AJax call 
$app->post('/updateZipCode', 'UsersController:updateZipCode')->setName('updateZipCode');
$app->get('/getId', 'UsersController:getId')->setName('getId');
$app->get('/updateLocation', 'UsersController:updateLocation')->setName('updateLocation');
$app->get('/getCity', 'UsersController:getCity')->setName('getCity');
$app->post('/updateLocationProfil', 'UsersController:updateLocationProfil')->setName('updateLocationProfil');
$app->get('/users/updateLocation/{id}', 'UsersController:updateUsersLocation')->setName('updateUsersLocation');
$app->post('/like', 'NotificationsController:like')->setName('like');
$app->get('/getLike', 'NotificationsController:getLike')->setName('like');
$app->get('/getUnreadNotif', 'NotificationsController:getUnreadNotif')->setName('getUnreadNotif');
$app->post('/readNotif', 'NotificationsController:readNotif')->setName('getUnreadNotif');
$app->get('/getCountNotif', 'NotificationsController:getCountNotif')->setName('getCountNotif');
$app->get('/setAsDefault/{id}', 'UsersController:setAsDefault')->setName('default');
$app->get('/deleteImage/{id}', 'UsersController:deleteImage')->setName('delete');

$app->get('/loca/{id}', 'UsersController:loca')->setName('loca');
$app->get('/blockedUsers', 'UsersController:blockAction')->setName('blocked');

// CHat

$app->get('/chat/{id}', 'ChatController:index')->setName('chatIndex')->add(new isConnected($app->getContainer()));
$app->post('/postMessage', 'ChatController:postMessage')->setName('postMsg')->add(new isConnected($app->getContainer()));
$app->get('/getMessage', 'ChatController:getMessage')->setName('getMsg')->add(new isConnected($app->getContainer()));
$app->get('/listChat/{id}', 'ChatController:listChat')->setName('chat');

$app->get('/fillDB', 'UsersController:fillDB')->setName('fillDB');

