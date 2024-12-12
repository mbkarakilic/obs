<?php
require "../../config/config.php";

// Gelen ID'yi al
$id = $_POST['id'];

$courseName = $_POST['courseName'];
$departmentId = (int) $_POST["department_id"];
$semester = (int) $_POST["semester"];
$ects = (int) $_POST["ects"];

// Veritabanında sorgulama yap
$query = "UPDATE courses SET  name = '$courseName', department_id = $departmentId, semester = $semester, ects = $ects WHERE id = $id";
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
