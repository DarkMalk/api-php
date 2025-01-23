<?php

require 'vendor/autoload.php';

require_once 'controllers/AuthController.php';
require_once 'controllers/NotesController.php';
require_once 'middleware/auth.php';

Flight::group('/api', function () {
  // Auth routes
  Flight::group('/auth', function () {
    Flight::route('POST /login', 'AuthController->login');
    Flight::route('POST /register', 'AuthController->register');
  });

  // Notes routes
  Flight::resource('/notes', NotesController::class, [
    'only' => ['index', 'show', 'update', 'destroy'],
    'middleware' => [AuthMiddleware::class]
  ]);
});

Flight::start();
