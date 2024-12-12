<?php
require "../../config/config.php";

// Gelen ID'yi al
$id = $_POST['id'];
$course_id = (int)$_POST['course_id'];
$date = $_POST['date'];
$type = $_POST['type'];
$percent = $_POST['percent'];

// Veritabanında sorgulama yap
$query = "UPDATE exams SET course_id = $course_id, date = '$date', type=$type, percent=$percent WHERE id = $id";
// echo $query;
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
