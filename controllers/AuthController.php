<?php

use Firebase\JWT\JWT;

require_once "utils/status_http.php";
require_once "config/env.php";

define("SECRET_KEY", $secret_key);

class AuthController
{
  public function login()
  {
    try {
      $body = Flight::request()->getBody();
      $data = json_decode($body, true);

      if (empty($data)) {
        Flight::jsonHalt(["message" => "Invalid request body"], StatusHTTP::BAD_REQUEST->value);
      }

      $username = $data["username"] ?? "";
      $password = $data["password"] ?? "";

      if (empty($username) || empty($password)) {
        Flight::jsonHalt(["message" => "Username and password are required"], StatusHTTP::BAD_REQUEST->value);
      }

      $sql = "SELECT * FROM user WHERE username = '$username'";
      $result = DB->query($sql);
      $user = $result->fetch_assoc();

      if (empty($user)) {
        Flight::jsonHalt(["message" => "User not found"], StatusHTTP::NOT_FOUND->value);
      }

      $password_verify = password_verify($password, $user["password"]);

      if (!$password_verify) {
        Flight::jsonHalt(["message" => "User or password invalid"], StatusHTTP::UNAUTHORIZED->value);
      }

      $payload = [
        "id" => $user["id"],
        "username" => $user["username"]
      ];

      $token = JWT::encode($payload, SECRET_KEY, "HS256");

      Flight::json(
        [
          "message" => "User logged successfully",
          "token" => $token
        ],
        StatusHTTP::OK->value
      );
    } catch (Exception $e) {
      Flight::jsonHalt(["message" => "Failed to login: " . $e->getMessage()], StatusHTTP::SERVER_ERROR->value);
    }
  }

  public function register()
  {
    try {
      $body = Flight::request()->getBody();
      $data = json_decode($body, true);

      if (empty($data)) {
        Flight::jsonHalt(["message" => "Invalid request body"], StatusHTTP::BAD_REQUEST->value);
        return;
      }


      $username = $data["username"] ?? "";
      $password = $data["password"] ?? "";

      if (empty($username) || empty($password)) {
        Flight::jsonHalt(["message" => "Username and password are required"], StatusHTTP::BAD_REQUEST->value);
        return;
      }

      $password_encrypted = password_hash($password, PASSWORD_BCRYPT, ["cost" => 10]);

      $sql = "INSERT INTO user (username, password) VALUES ('$username', '$password_encrypted')";

      $response = DB->query($sql);
      Flight::json(["message" => "User created successfully"], StatusHTTP::CREATED->value);
    } catch (Exception $e) {
      Flight::jsonHalt(["message" => "Failed to create user: " . $e->getMessage()], StatusHTTP::SERVER_ERROR->value);
    }
  }
}
