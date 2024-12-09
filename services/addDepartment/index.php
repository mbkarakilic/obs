<?php

require "../../config/config.php";

// POST verilerini alın
$department_name = $_POST["departmentName"];

// INSERT sorgusu
$query = "INSERT INTO departments (name) VALUES ('$department_name')";

// Sorguyu çalıştır ve kontrol et
$res = array(
    "success" => mysqli_query($connection, $query),
);

echo json_encode($res);
