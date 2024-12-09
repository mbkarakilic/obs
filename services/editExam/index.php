<?php
require "../../config/config.php";

// Gelen ID'yi al
$id = $_POST['id'];
$course_id = $_POST['course_id'];
$date = $_POST['date'];
$type = $_POST['type'];

// Veritabanında sorgulama yap
$query = "UPDATE exams SET course_id = $course_id, date = '$date', type=$type WHERE id = $id";
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
