<?php
require "../../config/cors/cors.php";
require "../../config/database/DatabaseConnector.php";

date_default_timezone_set('Europe/Istanbul');

$data = json_decode(file_get_contents("php://input"), true);
print_r($data);

