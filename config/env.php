<?php

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASSWORD', 'DB_PORT', 'SECRET_KEY'])->notEmpty();

$db_host = $_ENV["DB_HOST"];
$db_name = $_ENV["DB_NAME"];
$db_user = $_ENV["DB_USER"];
$db_pass = $_ENV["DB_PASSWORD"];
$db_port = $_ENV["DB_PORT"];
$secret_key = $_ENV["SECRET_KEY"];
