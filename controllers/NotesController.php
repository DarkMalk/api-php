<?php

require_once "utils/status_http.php";
require_once "config/database.php";

class NotesController
{
  public function index()
  {
    $user = (array) Flight::get('user_logged');
    $id_user = $user['id'];

    try {
      $sql = "SELECT id, text FROM note WHERE id_user = $id_user";

      $response = DB->query($sql);
      $notes = $response->fetch_all(MYSQLI_ASSOC);

      Flight::json($notes, StatusHTTP::OK->value);
    } catch (Exception $e) {
      Flight::jsonHalt(["message" => "Error to get notes"], StatusHTTP::SERVER_ERROR->value);
    }
  }

  public function show(string $id)
  {
    $user = (array) Flight::get('user_logged');
    $id_user = $user['id'];

    try {
      $sql = "SELECT id, text FROM note WHERE id_user = $id_user AND id = $id";

      $response = DB->query($sql);
      $note = $response->fetch_assoc();

      if (!$note) {
        Flight::jsonHalt(["message" => "Note not found"], StatusHTTP::NOT_FOUND->value);
      }

      Flight::json($note, StatusHTTP::OK->value);
    } catch (Exception $e) {
      Flight::jsonHalt(["message" => "Error to get note"], StatusHTTP::SERVER_ERROR->value);
    }
  }

  public function update(string $id)
  {
    $user = (array) Flight::get('user_logged');
    $id_user = $user['id'];

    $body = Flight::request()->getBody();
    $data = json_decode($body, true);

    if (empty($data) || !isset($data['text'])) {
      Flight::jsonHalt(["message" => "text is required"], StatusHTTP::BAD_REQUEST->value);
    }

    $text = $data['text'];

    try {
      $sql = "UPDATE note SET text = '$text' WHERE id_user = $id_user AND id = $id";

      $response = DB->query($sql);
      if (DB->affected_rows === 0) {
        Flight::jsonHalt(null, StatusHTTP::NOT_MODIFIED->value);
      }

      Flight::json(["message" => "Note updated"], StatusHTTP::OK->value);
    } catch (Exception $e) {
      Flight::jsonHalt(["message" => "Error to update note"], StatusHTTP::SERVER_ERROR->value);
    }
  }

  public function destroy(string $id)
  {
    $user = (array) Flight::get('user_logged');
    $id_user = $user['id'];

    try {
      $sql = "DELETE FROM note WHERE id_user = $id_user AND id = $id";

      $response = DB->query($sql);
      if (DB->affected_rows === 0) {
        Flight::jsonHalt(null, StatusHTTP::NOT_MODIFIED->value);
      }

      Flight::json(["message" => "Note deleted"], StatusHTTP::OK->value);
    } catch (Exception $e) {
      Flight::jsonHalt(["message" => "Error to delete note"], StatusHTTP::SERVER_ERROR->value);
    }
  }
}
