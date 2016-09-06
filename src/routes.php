<?php
// Routes

$router = new Router($app);

$router->get('/mvc', 'Pages@index');
$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");
	$pdo = $this->db->prepare('SELECT * FROM users');
	$pdo->execute();

    // Render index view
    return $this->view->render($response, 'index.html.twig', $args);
})->setName('homepage');
