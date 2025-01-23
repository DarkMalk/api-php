<?php

require_once "config/env.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthMiddleware
{
  public function before()
  {
    $authorization = Flight::request()->getHeader('Authorization', '');

    if (!$authorization || !str_starts_with($authorization, 'Bearer ')) {
      Flight::jsonHalt(["message" => "Token not provided"], StatusHTTP::UNAUTHORIZED->value);
    }

    $token = substr($authorization, 7);

    try {
      $decoded = (array) JWT::decode($token, new Key(SECRET_KEY, "HS256"));

      Flight::set('user_logged', $decoded);
    } catch (Exception $e) {
      Flight::jsonHalt(["message" => "Invalid token"], StatusHTTP::UNAUTHORIZED->value);
    }
  }
}
