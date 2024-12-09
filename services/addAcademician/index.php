<?php

require "../../config/config.php";

// POST verilerini alın
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$nationalId = $_POST["nationalId"];
$isAdmin = (int) $_POST["isAdmin"];
$department_id = (int) $_POST["department_id"];

// INSERT sorgusu
$query = "INSERT INTO academics (name, surname, nationalId, password, isAdmin, department_id) VALUES ('$firstname', '$lastname', '$nationalId', '$nationalId', $isAdmin, $department_id)";

// Sorguyu çalıştır ve kontrol et
$res = array(
    "success" => mysqli_query($connection, $query),
);

echo json_encode($res);
