<?php

require_once __DIR__ . '/../app/vendor/autoload.php';
require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/User.php';
require_once __DIR__ . '/../src/Post.php';
require_once __DIR__ . '/../src/Comment.php';
require_once __DIR__ . '/../src/UserController.php';
require_once __DIR__ . '/../src/PostController.php';
require_once __DIR__ . '/../src/CommentController.php';
require_once __DIR__ . '/../src/ApiController.php';
require_once __DIR__ . '/../src/Request.php';
require_once __DIR__ . '/../src/Response.php';

use RudyVieira\Database;
use RudyVieira\User;
use RudyVieira\Post;
use RudyVieira\Comment;
use RudyVieira\UserController;
use RudyVieira\PostController;
use RudyVieira\CommentController;
use RudyVieira\Request;
use RudyVieira\Response;

$database = new Database();
$user = new User($database);
$post = new Post($database);
$comment = new Comment($database);
$userController = new UserController($user);
$postController = new PostController($post);
$commentController = new CommentController($comment);
$request = new Request();
$response = new Response();

$method = $request->getMethod();
$uri = $request->getUri();
$uri = str_replace('/api/', '', $uri);

switch (true) {
    case $method === 'GET' && preg_match('#^users/(\d+)/?$#', $uri, $matches):
        $userController->show($matches[1]);
        break;
    case $method === 'POST' && preg_match('#^users/?$#', $uri):
        $userController->store();
        break;
    case $method === 'PUT' && preg_match('#^users/(\d+)/?$#', $uri, $matches):
        $userController->update($matches[1]);
        break;
    case $method === 'DELETE' && preg_match('#^users/(\d+)/?$#', $uri, $matches):
        $userController->destroy($matches[1]);
        break;

    case $method === 'GET' && preg_match('#^posts/(\d+)/?$#', $uri, $matches):
        $postController->show($matches[1]);
        break;
    case $method === 'POST' && preg_match('#^posts/?$#', $uri):
        $postController->store();
        break;
    case $method === 'PUT' && preg_match('#^posts/(\d+)/?$#', $uri, $matches):
        $postController->update($matches[1]);
        break;
    case $method === 'DELETE' && preg_match('#^posts/(\d+)/?$#', $uri, $matches):
        $postController->destroy($matches[1]);
        break;

    case $method === 'GET' && preg_match('#^comments/(\d+)/?$#', $uri, $matches):
        $commentController->show($matches[1]);
        break;
    case $method === 'POST' && preg_match('#^comments/?$#', $uri):
        $commentController->store();
        break;
    case $method === 'DELETE' && preg_match('#^comments/(\d+)/?$#', $uri, $matches):
        $commentController->destroy($matches[1]);
        break;

    default:
        $response->sendJson(['error' => 'Route not found'], 404);
        break;
}