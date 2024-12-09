<?php
require "../../config/config.php";

// Gelen ID'yi al
$id = $_POST['id'];
$nationalId = $_POST['nationalId'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$departmentId = (int) $_POST['department_id'];

// Veritabanında sorgulama yap
$query = "UPDATE students SET nationalId = '$nationalId', name = '$firstname', surname = '$lastname', department_id = $departmentId WHERE id = $id";
$result = mysqli_query($connection, $query);

// Sonuçları kontrol et
if ($result) {
    echo json_encode([
        "success" => true,
    ]);
} else {
    echo json_encode([
        "success" => false,
    ]);
}
