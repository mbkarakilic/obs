<?php
require "../../config/config.php";

// Gelen ID'yi al
$id = $_POST['courseId'];

// Veritabanında sorgulama yap
$query = "SELECT courses.*, departments.name AS department_name FROM courses JOIN departments ON courses.department_id = departments.id WHERE courses.id = $id";
$result = mysqli_query($connection, $query);
$semesterType = mysqli_fetch_assoc($result);

// Sonuçları kontrol et
if ($result && mysqli_num_rows($result) > 0) {
    echo json_encode([
        "success" => true,
        "course" => $semesterType,
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "ders bulunamadi",
    ]);
}
