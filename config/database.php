<?php

require_once "config/env.php";

$db = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);

define("DB", $db);
